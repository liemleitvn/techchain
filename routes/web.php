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
Route::get('/',['as'=>'login','uses'=>'AdminLoginController@getLogin']);
Route::post('/',['as'=>'postLogin','uses'=>'AdminLoginController@postLogin']);

Route::get('logout',['as'=>'getLogout','uses'=>'AdminLoginController@getLogout']);
Route::get('finish',['as'=>'finish','uses'=>'UserController@finish']);

//Route user
Route::group(['prefix'=>'user','middleware'=>['checkUser']], function(){
    Route::get('/',['as'=>'userIndex','uses'=>'UserController@getIndex']);
    Route::post('update-start-time',['as'=>'updateStartTime','uses'=>'UserController@updateStartTime']);
    Route::group(['middleware' => 'userStart'], function() {
        Route::get('start',['as'=>'userStart','uses'=>'UserController@getIndexStart']);
        Route::post('update-end-time',['as'=>'updateEndTime','uses'=>'UserController@updateEndTime']);
        Route::get('question',['as'=>'getDataQuestionPaginate','uses'=>'UserController@getDataQuestionPaginate']);
        Route::post('add-result-of-user',['as'=>'addResultOfUser','uses'=>'UserController@addResultOfUser']);
        Route::get('finish-close-account',['as'=>'finishClose','uses'=>'UserController@finishCloseAccount']);
    });
});

Route::middleware(['checkAdmin'])->group(function () {
    Route::group(['prefix'=>'admin'], function(){
        Route::resources([
            'level'=>'AdminLevelResourceController',
            'skill'=>'AdminSkillResourceController',
            'category'=>'AdminCategoryResourceController',
            'user'=>'AdminUserResourceController',
        ]);
        Route::group(['middleware' => 'superAdmin'], function() {
          Route::resources(['account-admin'=>'AdminAccountResourceController']);
        });
        //Route question
        Route::group(['prefix'=>'question'], function(){
            Route::get('/{nameSkill}/{nameCate?}',['as'=>'questionIndex','uses'=>'AdminQuestionResourceController@index']);
            Route::post('{nameSkill}',['as'=>'questionStore','uses'=>'AdminQuestionResourceController@store']);
            Route::delete('{nameSkill}/{id}',['as'=>'questionDelete','uses'=>'AdminQuestionResourceController@destroy']);
            Route::post('{nameSkill}/{id}',['as'=>'questionEdit','uses'=>'AdminQuestionResourceController@update']);
        });
        //Route user result
        Route::group(['prefix'=>'user-result'], function(){
            Route::get('/',['as'=>'userResultIndex','uses'=>'AdminUserResultController@index']);
            Route::get('result',['as'=>'getDataResult','uses'=>'AdminUserResultController@result']);
        });

        Route::post('import',['as'=>'questionImport','uses'=>'AdminQuestionResourceController@importFile']);
        //Route answer
        Route::group(['prefix'=>'answer'], function(){
            Route::get('delete/{id}',['as'=>'deleteAnswer','uses'=>'AdminAnswerController@deleteAnswer']);
        });
        //Route Setting
        Route::group(['prefix'=>'setting','middleware'=>'superAdmin'], function(){
            Route::get('/',['as'=>'settingIndex','uses'=>'AdminSettingController@index']);
            Route::get('/{id}',['as'=>'settingUpdate','uses'=>'AdminSettingController@update']);
        });
        //Change password an admin
        Route::get('change-password/{id}',['as'=>'changePassword','uses'=>'AdminAccountResourceController@changePassword']);
    });
});
