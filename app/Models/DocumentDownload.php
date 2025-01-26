<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentDownload extends Model {
    use SoftDeletes;

    protected $table = 'document_download';
}
