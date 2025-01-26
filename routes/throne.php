<?php
Route::group(['namespace' => 'App\Http\Controllers\Auth'], function() {
    Route::get('/', ['as' => 'throne.login', 'uses' => 'AuthController@login']);
    Route::post('/login', ['middleware'=> 'login', 'as' => 'throne.login.check', 'uses' => 'AuthController@authenticate']);
    Route::match(['get','post'],'/uj-jelszo', ['as' => 'throne.login.new_password', 'uses' => 'AuthController@firstLogin']);
    Route::get('/logout', ['as' => 'throne.logout', 'uses' => 'AuthController@logout']);
    Route::get('/selectlanguage/{lang}/{url?}', ['as' => 'throne.selectlanguage', 'uses' => 'AuthController@selectAdminLanguage']);
});

Route::group(['middleware'=> 'auth','namespace' => 'App\Http\Controllers\Throne'], function() {
    Route::match(['get','post'],'/dashboard', ['as' => 'throne.dashboard', 'uses' => 'DashboardController@index']);
    Route::get('/user_online', ['as' => 'throne.dashboard.useronline', 'uses' => 'DashboardController@useronline']);
    Route::get('/saveStep/{name}', ['as' => 'throne.profil.step', 'uses' => 'ProfileController@saveStep']);
    Route::match(['post','get'],'/profile', ['as' => 'throne.profil', 'uses' => 'ProfileController@edit']);
    Route::post('/slugger', ['as' => 'throne.slugger', 'uses' => 'DashboardController@slugger']);
    Route::get('/jogosultsag', ['as' => 'throne.notPermission', 'uses' => 'DashboardController@notPermission']);

    Route::match(['post', 'get'], '/beallitasok', ['permission_name' => 'settings', 'as' => 'throne.settings.edit', 'uses' => 'SettingsController@edit'])->middleware('permission:edit');

    getRoute([
        'prefix' => 'felhasznalok',
        'permission_name' => 'admins',
        'controller' => 'Admin',
        'actions' => ['new','edit','delete'],
    ], function() {
        Route::get('/ban/{id}', ['as' => 'throne.admins.ban', 'uses' => 'AdminController@ban'])->middleware('permission:edit');
    });
    getRoute([
        'prefix' => 'jogosultsagok',
        'permission_name' => 'permissions',
        'controller' => 'Permission',
        'actions' => ['new','edit','delete']
    ]);
    getRoute([
        'prefix' => 'keresesek',
        'permission_name' => 'search',
        'controller' => 'Search',
        'actions' => ['export','api']
    ]);
    getRoute([
        'prefix' => 'emailek',
        'permission_name' => 'emails',
        'controller' => 'Emails',
        'actions' => ['edit']
    ]);
    getRoute([
        'prefix' => 'atiranyitasok',
        'permission_name' => 'redirects',
        'controller' => 'Redirects',
        'actions' => ['new','edit','delete','api']
    ]);
    getRoute([
        'prefix' => 'gyorsitotarak',
        'permission_name' => 'caches',
        'controller' => 'Caches',
        'actions' => ['delete','api']
    ]);
    getRoute([
        'prefix' => 'nyelvek',
        'permission_name' => 'languages',
        'controller' => 'Languages',
        'actions' => ['new','edit','text','sort','status','delete']
    ], function(){
        Route::get('/publish', ['as' => 'throne.languages.publish', 'uses' => 'LanguagesController@publish'])->middleware('permission:publish');

        Route::group(['prefix' => 'szotar', 'permission_name' => 'languages'], function () {
            Route::get('/', ['as' => 'throne.language_text', 'uses' => 'LanguagesController@text'])->middleware('permission:text');
            Route::match(['post', 'get'], '/edit/{id}', ['permission' => 'edit','as' => 'throne.language_text.edit', 'uses' => 'LanguagesController@text_edit'])->middleware('permission:text');

            Route::group(['prefix' => 'api'], function () {
                Route::post('/', ['as' => 'throne.language_text.api', 'uses' => 'LanguagesController@api']);
                Route::get('/', ['as' => 'throne.language_text.api', 'uses' => 'LanguagesController@page']);
            });
        });
    });
    getRoute([
        'prefix' => 'menu/{type}',
        'permission_name' => 'menu',
        'controller' => 'Menu',
        'actions' => ['new','edit','status','delete','sort','trash']
    ]);
    getRoute([
        'prefix' => 'oldalak',
        'permission_name' => 'pages',
        'controller' => 'Pages',
        'actions' => ['new','edit','status','delete','preview','archive','trash','api']
    ]);
    getRoute([
        'prefix' => 'fix-tartalmak',
        'permission_name' => 'fixedcontent',
        'controller' => 'FixedContent',
        'actions' => ['edit']
    ]);
    getRoute([
        'prefix' => 'slider',
        'permission_name' => 'slider',
        'controller' => 'Slider',
        'actions' => ['new','edit','text','sort','status','delete','trash','api']
    ]);
    getRoute([
        'prefix' => 'cikk-kategoriak',
        'permission_name' => 'feed_categories',
        'controller' => 'FeedCategories',
        'actions' => ['new','edit','sort','status','delete','trash','api']
    ]);
    getRoute([
        'prefix' => 'cimkek',
        'permission_name' => 'feed_labels',
        'controller' => 'FeedLabels',
        'actions' => ['new','edit','sort','status','delete','trash','api']
    ]);
    getRoute([
        'prefix' => 'cikkek',
        'permission_name' => 'feed_items',
        'controller' => 'FeedItems',
        'actions' => ['new','edit','featured','status','delete','preview','archive','trash','api']
    ]);
    getRoute([
        'prefix' => 'partner-kategoriak',
        'permission_name' => 'partner_categories',
        'controller' => 'PartnerCategories',
        'actions' => ['new','edit','sort','status','delete','trash','api']
    ]);
    getRoute([
        'prefix' => 'partnerek',
        'permission_name' => 'partner_items',
        'controller' => 'PartnerItems',
        'actions' => ['new','edit','sort','status','delete','trash','api']
    ]);
    getRoute([
        'prefix' => 'esemeny-kategoriak',
        'permission_name' => 'event_categories',
        'controller' => 'EventCategories',
        'actions' => ['new','edit','sort','status','delete','trash','api']
    ]);
    getRoute([
        'prefix' => 'esemenyek',
        'permission_name' => 'events',
        'controller' => 'Events',
        'actions' => ['new','edit','status','delete','trash','api']
    ]);
    getRoute([
        'prefix' => 'popup',
        'permission_name' => 'popup',
        'controller' => 'Popup',
        'actions' => ['new','edit','text','sort','status','delete','trash','api']
    ]);
    getRoute([
        'prefix' => 'regisztraltak',
        'permission_name' => 'users',
        'controller' => 'Users',
        'actions' => ['new','edit','status','delete','export','api']
    ]);
    getRoute([
        'prefix' => 'log',
        'permission_name' => 'logs',
        'controller' => 'Logs',
        'actions' => ['api']
    ]);

    Route::group(['prefix' => 'mediatar'], function () {
        Route::group(['prefix' => 'dokumentumok', 'permission_name' => 'documentcategory'], function () {
            Route::get('/{boss?}', ['as' => 'throne.documentcategory', 'uses' => 'DocumentCategoryController@index'])->middleware('permission:read');

            Route::group(['prefix' => 'folder/{boss}'], function () {
                Route::get('/', ['as' => 'throne.documentcategory.folder', 'uses' => 'DocumentCategoryController@index'])->middleware('permission:read');
                Route::match(['post', 'get'], '/new', ['as' => 'throne.documentcategory.new', 'uses' => 'DocumentCategoryController@create'])->middleware('permission:new');
                Route::match(['post', 'get'], '/edit/{id}/', ['as' => 'throne.documentcategory.edit', 'uses' => 'DocumentCategoryController@edit'])->middleware('permission:edit');

                Route::group(['prefix' => 'dokumentum', 'permission_name' => 'documentitem'], function () {
                    Route::match(['post', 'get'], '/new', ['as' => 'throne.documentitem.new', 'uses' => 'DocumentItemController@create'])->middleware('permission:new');
                    Route::match(['post', 'get'], '/edit/{id}', ['as' => 'throne.documentitem.edit', 'uses' => 'DocumentItemController@edit'])->middleware('permission:edit');
                });
            });

            Route::get('/status/{id}', ['as' => 'throne.documentcategory.status', 'uses' => 'DocumentCategoryController@status'])->middleware('permission:edit');
            Route::get('/delete/{id}', ['as' => 'throne.documentcategory.delete', 'uses' => 'DocumentCategoryController@delete'])->middleware('permission:delete');

            Route::group(['prefix' => 'item', 'permission_name' => 'documentitem'], function () {
                Route::get('/status/{id}', ['as' => 'throne.documentitem.status', 'uses' => 'DocumentItemController@status'])->middleware('permission:edit');
                Route::get('/delete/{id}', ['as' => 'throne.documentitem.delete', 'uses' => 'DocumentItemController@delete'])->middleware('permission:delete');
            });
        });

        Route::group(['prefix' => 'galeriak', 'permission_name' => 'gallery'], function () {
            Route::get('/', ['as' => 'throne.gallery', 'uses' => 'GalleryController@index'])->middleware('permission:read');

            Route::group(['prefix' => 'folder/{boss}'], function () {
                Route::get('/', ['as' => 'throne.gallery.folder', 'uses' => 'GalleryController@index'])->middleware('permission:read');
                Route::match(['post', 'get'], '/new', ['as' => 'throne.gallery.new', 'uses' => 'GalleryController@create'])->middleware('permission:new');
                Route::match(['post', 'get'], '/edit/{id}/', ['as' => 'throne.gallery.edit', 'uses' => 'GalleryController@edit'])->middleware('permission:edit');

                Route::group(['prefix' => 'kep', 'permission_name' => 'galleryimages'], function () {
                    Route::get('/', ['as' => 'throne.galleryimages', 'uses' => 'ImageController@index'])->middleware('permission:read');
                    Route::match(['post', 'get'], '/new', ['as' => 'throne.galleryimages.new', 'uses' => 'ImageController@create'])->middleware('permission:new');
                    Route::match(['post', 'get'], '/edit/{id}', ['as' => 'throne.galleryimages.edit', 'uses' => 'ImageController@edit'])->middleware('permission:edit');
                });
            });

            Route::get('/status/{id}', ['as' => 'throne.gallery.status', 'uses' => 'GalleryController@status'])->middleware('permission:edit');
            Route::get('/delete/{id}', ['as' => 'throne.gallery.delete', 'uses' => 'GalleryController@delete'])->middleware('permission:delete');

            Route::group(['prefix' => 'item', 'permission_name' => 'galleryimages'], function () {
                Route::get('/status/{id}', ['as' => 'throne.galleryimages.status', 'uses' => 'ImageController@status'])->middleware('permission:edit');
                Route::get('/delete/{id}', ['as' => 'throne.galleryimages.delete', 'uses' => 'ImageController@delete'])->middleware('permission:delete');
            });
        });

        Route::group(['prefix' => 'videok', 'permission_name' => 'videogallery'], function () {
            Route::get('/', ['as' => 'throne.videogallery', 'uses' => 'VideoGalleryController@index'])->middleware('permission:read');

            Route::group(['prefix' => 'folder/{boss}'], function () {
                Route::get('/', ['as' => 'throne.videogallery.folder', 'uses' => 'VideoGalleryController@index'])->middleware('permission:read');
                Route::match(['post', 'get'], '/new', ['as' => 'throne.videogallery.new', 'uses' => 'VideoGalleryController@create'])->middleware('permission:new');
                Route::match(['post', 'get'], '/edit/{id}/', ['as' => 'throne.videogallery.edit', 'uses' => 'VideoGalleryController@edit'])->middleware('permission:edit');

                Route::group(['prefix' => 'video', 'permission_name' => 'videoitem'], function () {
                    Route::match(['post', 'get'], '/new', ['as' => 'throne.videoitem.new', 'uses' => 'VideoController@create'])->middleware('permission:new');
                    Route::match(['post', 'get'], '/edit/{id}', ['as' => 'throne.videoitem.edit', 'uses' => 'VideoController@edit'])->middleware('permission:edit');
                });
            });

            Route::get('/status/{id}', ['as' => 'throne.videogallery.status', 'uses' => 'VideoGalleryController@status'])->middleware('permission:edit');
            Route::get('/delete/{id}', ['as' => 'throne.videogallery.delete', 'uses' => 'VideoGalleryController@delete'])->middleware('permission:delete');

            Route::group(['prefix' => 'item', 'permission_name' => 'videoitem'], function () {
                Route::get('/status/{id}', ['as' => 'throne.videoitem.status', 'uses' => 'VideoController@status'])->middleware('permission:edit');
                Route::get('/delete/{id}', ['as' => 'throne.videoitem.delete', 'uses' => 'VideoController@delete'])->middleware('permission:delete');
            });
        });
    });

    Route::group(['prefix' => 'urlapok', 'permission_name' => 'forms'], function () {
        Route::get('/', ['as' => 'throne.forms', 'uses' => 'FormsController@index'])->middleware('permission:read');
        Route::match(['post', 'get'], '/new', ['as' => 'throne.forms.new', 'uses' => 'FormsController@create'])->middleware('permission:new');
        Route::match(['post', 'get'], '/edit/{id}', ['as' => 'throne.forms.edit', 'uses' => 'FormsController@edit'])->middleware('permission:edit');
        Route::get('/status/{id}', ['as' => 'throne.forms.status', 'uses' => 'FormsController@status'])->middleware('permission:edit');
        Route::get('/live/{id}', ['as' => 'throne.forms.live', 'uses' => 'FormsController@live'])->middleware('permission:edit');
        Route::get('/copy/{id}/{lang}', ['as' => 'throne.forms.copy', 'uses' => 'FormsController@copy'])->middleware('permission:edit');
        Route::get('/delete/{id}', ['as' => 'throne.forms.delete', 'uses' => 'FormsController@delete'])->middleware('permission:delete');

        Route::get('/trash', ['as' => 'throne.forms.trash', 'uses' => 'FormsController@trash'])->middleware('permission:trash');
        Route::get('/trash/restore/{id}', ['as' => 'throne.forms.trash.restore', 'uses' => 'FormsController@trashRestore'])->middleware('permission:trash');
        Route::get('/trash/delete/{id}', ['as' => 'throne.forms.trash.delete', 'uses' => 'FormsController@trashDelete'])->middleware('permission:trash');

        Route::group(['prefix' => 'kitoltok/{form}', 'permission_name' => 'form_users'], function () {
            Route::get('/', ['as' => 'throne.form_users', 'uses' => 'FormUsersController@index'])->middleware('permission:read');
            Route::get('/export', ['as' => 'throne.form_users.export', 'uses' => 'FormUsersController@export'])->middleware('permission:export');
            Route::get('/show/{id}', ['as' => 'throne.form_users.show', 'uses' => 'FormUsersController@show'])->middleware('permission:show');
            Route::get('/delete/{id}', ['as' => 'throne.form_users.delete', 'uses' => 'FormUsersController@delete'])->middleware('permission:delete');
        });

        Route::group(['prefix' => 'tartalmak/{form}', 'permission_name' => 'form_content'], function () {
            Route::get('/', ['as' => 'throne.form_content', 'uses' => 'FormContentController@index'])->middleware('permission:read');
            Route::match(['get','post'],'/new', ['as' => 'throne.form_content.new', 'uses' => 'FormContentController@create'])->middleware('permission:new');
            Route::match(['get','post'],'/edit/{id}', ['as' => 'throne.form_content.edit', 'uses' => 'FormContentController@edit'])->middleware('permission:edit');
            Route::get('/delete/{id}', ['as' => 'throne.form_content.delete', 'uses' => 'FormContentController@delete'])->middleware('permission:delete');
        });

        Route::group(['prefix' => 'api'], function () {
            Route::post('/', ['as' => 'throne.forms.api', 'uses' => 'FormsController@api']);
            Route::get('/', ['as' => 'throne.forms.api', 'uses' => 'FormsController@page']);

            Route::group(['prefix' => 'form_users/{form}'], function () {
                Route::post('/', ['as' => 'throne.form_users.api', 'uses' => 'FormUsersController@api']);
                Route::get('/', ['as' => 'throne.form_users.api', 'uses' => 'FormUsersController@page']);
            });
        });
    });

    getRoute([
        'prefix' => 'widget',
        'permission_name' => 'widget',
        'controller' => 'Widget',
        'actions' => ['new','edit','status','delete','trash','api']
    ]);
});
Route::group(['middleware'=> 'auth','namespace' => 'App\Http\Controllers\Api'], function() {
    Route::group(['prefix' => 'api'], function () {
        Route::group(['prefix' => 'widget/{widget}'], function () {
            Route::get('/data', ['as' => 'throne.widget.api.data', 'uses' => 'WidgetController@widget']);
            Route::get('/refresh', ['as' => 'throne.widget.api.refresh', 'uses' => 'WidgetController@refresh']);
            Route::get('/addoption/{id}', ['as' => 'throne.widget.api.option', 'uses' => 'WidgetController@addoption']);

            Route::get('/add', ['as' => 'throne.widget.api.add', 'uses' => 'WidgetController@add']);
        });
        Route::group(['prefix' => 'media-manager'], function () {
            Route::get('/load/{type}', ['as' => 'throne.mediamanager.api.load', 'uses' => 'MediaManagerController@load']);
            Route::get('/get/{type}', ['as' => 'throne.mediamanager.api.get', 'uses' => 'MediaManagerController@get']);
            Route::get('/search/{type}', ['as' => 'throne.mediamanager.api.search', 'uses' => 'MediaManagerController@search']);
            Route::get('/view', ['as' => 'throne.mediamanager.api.view', 'uses' => 'MediaManagerController@manager_view']);
            Route::post('/fileUpload/{type}', ['as' => 'throne.mediamanager.api.fileupload', 'uses' => 'MediaManagerController@fileUpload']);
            Route::get('/downloadZip/{type}/{boss}', ['as' => 'throne.mediamanager.api.downloadzip', 'uses' => 'MediaManagerController@downloadZip']);
            Route::post('/paste/{type}/{boss}', ['as' => 'throne.mediamanager.api.paste', 'uses' => 'MediaManagerController@paste']);
        });
    });
});
