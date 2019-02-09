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



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$routes = function () {
    Route::get('/', [ 'as' => 'home', 'uses' => 'LoginController@home' ]);

    Route::get('logout', [ 'as' => 'logout', 'uses' => 'LoginController@logout' ]);
    Route::get('login', [ 'as' => 'login', 'uses' => 'LoginController@redirect' ]);
    Route::get('login/auth', [ 'as' => 'login_auth', 'uses' => 'LoginController@auth' ]);
    Route::get('login/cannot', [ 'as' => 'login_cannot', 'uses' => 'LoginController@cannot' ]);

    Route::group(['middleware'=>'vote'], function() {
        Route::get('vote', ['as' => 'vote_index', 'uses' => 'VoteController@index']);
        Route::get('vote/already', ['as' => 'vote_already', 'uses' => 'VoteController@already']);
        Route::get('vote/{id}', ['as' => 'vote_confirm', 'uses' => 'VoteController@confirm']);
        Route::get('vote/{id}/confirmed', ['as' => 'vote_doit', 'uses' => 'VoteController@doit']);
    });

    Route::group(['middleware'=>'admin'], function() {
        Route::get('admin', [ 'as' => 'admin_panel', 'uses' => 'AdminController@panel' ]);
        Route::get('admin/new', [ 'as' => 'admin_new', 'uses' => 'AdminController@create' ]);
        Route::post('admin/new/submit', [ 'as' => 'admin_new_submit', 'uses' => 'AdminController@new_submit' ]);
        Route::get('admin/edit/{id}', [ 'as' => 'admin_edit', 'uses' => 'AdminController@edit' ]);
        Route::post('admin/edit/{id}/submit', [ 'as' => 'admin_edit_submit', 'uses' => 'AdminController@edit_submit' ]);
        Route::get('admin/delete/{id}', [ 'as' => 'admin_delete_confirm', 'uses' => 'AdminController@delete_confirm' ]);
        Route::get('admin/delete/{id}/confirmed', [ 'as' => 'admin_delete', 'uses' => 'AdminController@delete' ]);
        Route::get('admin/reset', [ 'as' => 'admin_reset_confirm', 'uses' => 'AdminController@reset_confirm' ]);
        Route::get('admin/reset/confirmed', [ 'as' => 'admin_reset', 'uses' => 'AdminController@reset' ]);
    });
};

if (env('APP_ENV') === 'production') {
    URL::forceSchema('https');
}

if(env('APP_SUFFIX')) {
    Route::prefix(env('APP_SUFFIX'))->group($routes);
} else {
    Route::group([], $routes);
}


