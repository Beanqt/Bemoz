<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if($e instanceof TokenMismatchException){
                return redirect()->back()->withError(trans('admin.alert.token'));
            }

            if(request()->segment(1) == 'throne' && ($e instanceof \Spatie\LaravelIgnition\Exceptions\ViewException || (!$e->getMessage() && $e->getStatusCode() == '404'))){
                return response()->view('errors.throne_404', [], 404);
            }

            if(request()->segment(1) == 'cron' && !$e->getMessage() && $e->getStatusCode() == '404'){
                return response('404', 400);
            }

            if(!config('app.debug') && !$e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException){
                $url = url()->full();
                $error = $e->getMessage();

                if(!session()->has('exception.'.(slug($url))) && !empty($error)){
                    $content = '<b>Url:</b> '.$url.'<br><b>Error:</b>'.$error.'<br><b>Line:</b>'.$e->getLine().'<br><b>File:</b>'.$e->getFile();
                    Mail::send('emails.default', ['content' => $content], function($message){
                        $message->to('ledniczki.tibor@positive.hu')->subject('Error: '.url()->full());
                        $message->to('szolnoki.andras@positive.hu')->subject('Error: '.url()->full());
                    });

                    session()->put('exception.'.(slug($url)), true);
                }

                if(strpos($e->getMessage(), 'Too many connections')){
                    return response()->view('errors.minimal', [], 503);
                }
                return response()->view('errors.500', [], 500);
            }
        });
    }
}
