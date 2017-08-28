<?php

Route::group(['prefix'=>'image'], function() {

	// Get image by Name
	Route::get('original/{image}/{path}', function(Request $request, $image,$path) {
		$filename = $path.'/'.$image;
		if($image !='null' && Storage::exists($filename)) {
			return response(Storage::get($filename))->header('Content-Type', 'image/*');
		} else {
			return response(Storage::get('no-image.jpg'))->header('Content-Type', 'image/*');
		}
	})->name('get-image-original');

	// Get resized image by Name
	Route::get('resize/{image}/{path}', function(Request $request, $image,$path) {
		$filename = $path.'/resize/'.$image;
		if($image !='null' && Storage::exists($filename)) {
			return response(Storage::get($filename))->header('Content-Type', 'image/*');
		} else {
			return response(Storage::get('no-image.jpg'))->header('Content-Type', 'image/*');
		}
	})->name('get-image-resize');

});

Route::group(['prefix'=>'category'], function() {
	Route::get('{id}', function(Request $request, $id) {
		$filename = 'avatars/'.$id.'.png';
		if(Storage::exists($filename)) {
			return response(Storage::get($filename))->header('Content-Type', 'image/png');
		} else {
			//return response(Storage::get('avatars/no-image.png'))->header('Content-Type', 'image/png');
		}
	})->name('get-image');

	

	Route::get('100x100/{id}', function(Request $request, $id) {
		$filename = 'avatars/100x100/'.$id.'.png';
		if(Storage::exists($filename)) {
			return response(Storage::get($filename))->header('Content-Type', 'image/png');
		} else {
			//return response(Storage::get('avatars/100x100/no-image.png'))->header('Content-Type', 'image/png');
		}
	})->name('account-avatar-100x100');

	Route::get('200x200/{id}', function(Request $request, $id) {
		$filename = 'avatars/200x200/'.$id.'.png';
		if(Storage::exists($filename)) {
			return response(Storage::get($filename))->header('Content-Type', 'image/png');
		} else {
			//return response(Storage::get('avatars/200x200/no-image.png'))->header('Content-Type', 'image/png');
		}
	})->name('account-avatar-200x200');

	Route::get('/employer/{id}', function(Request $request, $id) {
		$filename = 'avatars/employers/'.$id.'.png';
		if(Storage::exists($filename)) {
			return response(Storage::get($filename))->header('Content-Type', 'image/png');
		} else {
			//return response(Storage::get('avatars/no-company.png'))->header('Content-Type', 'image/png');
		}
	})->name('account-employer-avatar');

});

Route::group(['prefix'=>'download'], function() {
	Route::get('', function(Request $request) {
			return response(Storage::get('avatars/resume.png'))->header('Content-Type', 'image/png');
	})->name('resume-image');
});