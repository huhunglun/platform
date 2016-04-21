<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/', 'HomeController@index');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => ['cors']], function () {

    Route::get('api/getkey', 'ApiController@getKey');
    Route::get('api/getContent', 'ApiController@getContent');
    Route::get('api/facebooklogout','ApiController@facebookLogout');

    Route::post('api/adduserapp', 'ApiController@addUserApp');
    Route::post('api/adduserfeedback','ApiController@addUserFeedback');
    Route::get('api/connect', 'ApiController@connect');
    Route::get('api/getvuforiatargetstatus/{targetId}', 'ApiController@getVuforiaTargetStatus');
    Route::get('api/updatevuforiatargetstatus/{targetId}', 'ApiController@updateVuforiaTargetStatus');
});

Route::group(['middleware' => ['web']], function () {

});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
//    Route::get('/', 'HomeController@index');

    Route::get('/', 'VuforiaController@getTarget');
    Route::get('/vuforia', 'VuforiaController@index');
    Route::get('/admin/{role?}', 'VuforiaController@admin');
    Route::bind('role', function($role, $route) {
        return $role;
    });
    //List Target
    Route::get('/getusertarget/{userId}', 'VuforiaController@getUserTarget');
    Route::bind('userId', function($userId, $route) {
        return $userId;
    });

    //Post Target
    Route::post('/vuforia/checkFileNameDuplicate', 'VuforiaController@checkFileNameDuplicate');
    Route::post('/vuforia/uploadImage', 'VuforiaController@uploadImage');
    Route::post('/vuforia/vuforiaAction', 'VuforiaController@vuforiaAction');
    Route::post('/vuforia/storetarget', 'VuforiaController@storeTarget');

    //Update Target
    Route::post('/vuforia/updatetarget', 'VuforiaController@updateTarget');

    Route::post('/vuforia/targetdelete', 'VuforiaController@targetDelete');

    //Show Detail Target
    Route::get('/targets/{targetId}/{userId?}', 'VuforiaController@showTargetDetail');

    //Helper
    Route::post('/vuforia/uploadTargetsImage', 'VuforiaController@uploadTargetsImage');
    Route::post('/vuforia/uploadTargetsVideo', 'VuforiaController@uploadTargetsVideo');

    Route::post('/vuforia/imagetargetdelete', 'VuforiaController@imageTargetDelete');
    Route::post('/vuforia/videotargetdelete', 'VuforiaController@videoTargetDelete');
    Route::post('/vuforia/targetdelete', 'VuforiaController@targetDelete');
    Route::post('/vuforia/imagetargetupdate', 'VuforiaController@imageTargetUpdate');
    Route::post('/vuforia/userdelete', 'VuforiaController@userDelete');
    Route::post('/vuforia/uploadtargetsyoutube', 'VuforiaController@uploadTargetsYoutube');

    Route::post('/vuforia/validateyoutubeurl', 'VuforiaController@validateYoutubeUrl');

    Route::post('/vuforia/createuser', 'VuforiaController@createUser');
    Route::post('/vuforia/createadmin', 'VuforiaController@createAdmin');
    Route::post('/vuforia/modifyuser', 'VuforiaController@modifyUser');

    Route::post('/vuforia/checkUserNameDuplicate', 'VuforiaController@checkUserNameDuplicate');
    Route::post('/vuforia/updatestatus', 'VuforiaController@updateStatus');

    Route::post('/vuforia/checkModifyUserNameDuplicate', 'VuforiaController@checkModifyUserNameDuplicate');

    //Social Provider
    Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
    Route::bind('provider', function($provider, $route) {
        return $provider;
    });
    Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');
    Route::bind('provider', function($provider, $route) {
        return $provider;
    });

    Route::get('/success', 'Auth\AuthController@handleProviderCallbackSuccess');

    Route::get('/socialuser', 'VuforiaController@socialUser');
    Route::post('/vuforia/deletesocialuser', 'VuforiaController@deleteSocialUser');


    Route::get('/feedback', 'VuforiaController@feedback');
    Route::post('/sendfeedbackemail', 'VuforiaController@sendFeedbackEmail');

});

