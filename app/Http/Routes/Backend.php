<?php

Route::get('/','Backend\DashboardController@index')->name("dashboard");

/*===  Admin Authentication routes... ==== */	
Route::group(['prefix'=>'admin', 'namespace'=>'Auth'],function(){
	
	/*=== Admin Login routes... ==== */	
	Route::get('login', 'AuthController@getLogin')->name('getLoginPage');
	Route::post('login', 'AuthController@postLogin')->name('postLoginPage');
	Route::get('logout', 'AuthController@getLogout')->name('getLogOutPage');
	
	/*===  Admin forgot password routes... ==== */
	Route::get('forgot-password', 'AuthController@getForgotPassword')->name('getAdminForgotPassword');
	Route::post('forgot-password', 'AuthController@postForgotPassword')->name('postAdminForgotPassword');
	
	/*===  Admin change password routes... ==== */
	Route::get('change-password', 'AuthController@getChangePassword')->name('getAdminChangePassword');
	Route::post('change-password', 'AuthController@postChangePassword')->name('postAdminChangePassword');

	/*===  Admin Registration routes... ==== */
	Route::get('register', 'AuthController@getRegister');
	Route::post('register', 'AuthController@postRegister');
});

Route::group(['prefix'=>'admin', 'namespace'=>'Backend'],function(){
	
	/*=== Home routes ==== */		
		Route::get('/','DashboardController@index')->name("dashboard");
	/*=== Home routes End ==== */

	/*=== Brand routes ==== */	
	Route::get('/brand','BrandController@getbrandlishting')->name("brandslisting");
	Route::post('/brand','BrandController@postbrandlishting')->name("post-brandslisting");

	Route::get('/add-brand','BrandController@getAdminAddnewBrand')->name("getAdminAddBrand");
	Route::post('/add-brand','BrandController@postAdminAddnewBrand')->name("postAdminAddBrand");

	Route::get('/edit-brand/{Brand}','BrandController@getAdminEditBrand')->name("getAdminEditBrand");
	Route::post('/edit-brand/{Brand}','BrandController@postAdminEditBrand')->name("postAdminEditBrand");

	Route::get('/delete-brand/{Brand}','BrandController@getAdminDeleteBrand')->name("postAdminDeleteBrand");
	/*=== Brand routes End ==== */


	/*=== Model routes ==== */	
	Route::get('/model','ModelController@getmodellishting')->name("modellisting");
	Route::post('/model','ModelController@postmodellishting')->name("postModellisting");

	Route::get('/add-model','ModelController@getAdminAddModel')->name("getAdminAddModel");
	Route::post('/add-model','ModelController@postAdminAddModel')->name("postAdminAddModel");

	Route::get('/edit-model/{Model}','ModelController@getAdminEditModel')->name("getAdminEditModel");
	Route::post('/edit-model/{Model}','ModelController@postAdminEditModel')->name("postAdminEditModel");

	Route::get('/delete-model/{Model}','ModelController@getAdminDeleteModel')->name("postAdminDeleteModel");
	/*=== Model routes End ==== */

	/*=== Model details routes ==== */	
	Route::get('/model-details','ModelDetailsController@getmodelDetailslishting')->name("modelDetailslisting");
	Route::post('/model-details','ModelDetailsController@postmodelDetailslishting')->name("postModelDetailslisting");

	Route::get('/add-model-details','ModelDetailsController@getAdminAddModelDetails')->name("getAdminAddModelDetails");
	Route::post('/add-model-details','ModelDetailsController@postAdminAddModelDetails')->name("postAdminAddModelDetails");

	Route::get('/edit-model-details/{ModelDetails}','ModelDetailsController@getAdminEditModelDetails')->name("getAdminEditModelDetails");
	Route::post('/edit-model-details/{ModelDetails}','ModelDetailsController@postAdminEditModelDetails')->name("postAdminEditModelDetails");

	Route::get('/delete-model-details/{ModelDetails}','ModelDetailsController@getAdminDeleteModelDetails')->name("postAdminDeleteModelDetails");
	Route::get('get-ajax-model/','ModelDetailsController@getAjaxModel')->name("getAdminModelByAjax");
	/*=== Model details routes End ==== */



});

// public routes
Route::get('/recordperpage',['uses'=>"CommonController@getRecordPerPage","as"=>'api-public-recordPerPage']);
Route::get('/change-status',['uses'=>"CommonController@getChangeStatus","as"=>'api-public-change-status']);
