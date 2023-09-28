<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('json/{site}/{local}/{page}/{key}', [ 'as' => 'json', 'uses' => 'JsonGenerateController@index' ]);

Route::get('login', [ 'as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin' ]);
Route::post('login', [ 'as' => 'auth.postLogin', 'uses' => 'Auth\AuthController@postLogin' ]);
Route::get('logout', [ 'as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout' ]);

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [
        'as' => 'dashboard.index',
        'uses' => 'DashboardController@index',
    ]);

    Route::resource('site', 'SiteController');
    //Route::resource('language', 'LanguageController');
    Route::resource('user', 'UserController');


    Route::get('page/lookup', 'PageController@lookup');
    Route::get('page/duplicate/{id}', [ 'as' => 'page.duplicate', 'uses' => 'PageController@duplicate' ]);
    Route::resource('page', 'PageController');

    Route::resource('page-type', 'PageTypeController');
    Route::get('page-type/{id}/templates', 'PageTypeController@templates');
    Route::get('page-type/{id}/render/{page?}', array('as' => 'page-type.render', 'uses' => 'PageTypeController@render'));

    Route::resource('page-template', 'PageTemplateController');
    Route::get('page/preview/{id}', [ 'as' => 'page.preview', 'uses' => 'PageController@preview' ]);
    Route::get('view/{id}/duplicate', [ 'as' => 'view.duplicate', 'uses' => 'ViewController@duplicate' ]);
    Route::resource('view', 'ViewController');

    Route::resource('taxonomy', 'TaxonomyController');
    Route::get('widget/lookup/{query}', array('as' => 'widget.lookup', 'uses' => 'WidgetController@lookup'));
    Route::get('widget/configure/{type}', [ 'as' => 'widget.configure', 'uses' => 'WidgetController@configure' ]);
    Route::get('widget/{id}/duplicate', [ 'as' => 'widget.duplicate', 'uses' => 'WidgetController@duplicate' ]);
    Route::resource('widget', 'WidgetController');
    Route::resource('widget-type', 'WidgetTypeController');
    //Route::resource('faq', 'FaqController');
    Route::get('menu/lookup', 'MenuController@lookup');
    Route::resource('menu', 'MenuController');
    Route::resource('translation', 'TranslationController');
    Route::get('field/configure/{type}', [ 'as' => 'field.configure', 'uses' => 'FieldController@configure' ]);

    Route::get('field/create', [ 'as' => 'field.create', 'uses' => 'FieldController@create' ]);
    Route::get('field/{id}', [ 'as' => 'field.preview', 'uses' => 'FieldController@preview' ]);
    Route::resource('field', 'FieldController');
    Route::get('field/{id}/filters', 'FieldController@filters');
    Route::get('field/{id}/filter/{condition}', 'FieldController@filter');
    Route::resource('storage', 'StorageController');
    Route::resource('taxonomy', 'TaxonomyController');

    // Media manager
    Route::get('media', array('as' => 'media.index', 'uses' => 'MediaController@index'));
    Route::get('media/upload', array('as' => 'media.upload', 'uses' => 'MediaController@upload'));
    Route::post('media/upload', array('as' => 'media.store', 'uses' => 'MediaController@store'));
    Route::get('media/{id}/edit', array('as' => 'media.edit', 'uses' => 'MediaController@edit'));
    Route::patch('media/{id}', [ 'as' => 'media.update', 'uses' => 'MediaController@update' ]);
    Route::delete('media/{id}', array('as' => 'media.destroy', 'uses' => 'MediaController@destroy'));

    //Route::get('settings', array('as' => 'settings', 'uses' => 'SettingController@index'));
    //Route::post('settings/add-api-key', array('as' => 'setting.add-api-key', 'uses' => 'SettingController@addApiKey'));

    // Help and documentation
    Route::get('help/{topic}', [ 'as' => 'help.topic', 'uses' => 'HelpController@topic' ]);
});

Route::group([ 'prefix' => 'api', 'middleware' => 'api' ], function() {
    Route::get('pages/search', [ 'uses' => 'Api\PageController@search' ]);
    Route::resource('pages', 'Api\PageController', [ 'only' => [ 'index', 'show' ] ]);
    Route::resource('sites', 'Api\SiteController', [ 'only' => [ 'show' ] ]);
    Route::resource('widgets', 'Api\WidgetController', [ 'only' => [ 'show' ] ]);
    Route::resource('translation', 'Api\TranslationController', [ 'except' => [ 'create', 'edit' ] ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
