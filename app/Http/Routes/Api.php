<?php

Route::group(['prefix'=>'Api', 'namespace'=>'Api'], function(){
	
	Route::post('/getMakeDetails','APIController@getMakeDetails')->name("getMakeDetails");
	Route::post('/getModels','APIController@getModels')->name("getModels");
	Route::post('/getModelDetails','APIController@getModelDetails')->name("getModelDetails");
	
});