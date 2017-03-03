<?php
Route::group(['prefix' => 'api/v1/'], function(){
	$namespace = 'App\Modules\Admin\Controllers';
	Route::group(
		['prefix' => 'admin', 'module'=>'Admin', 'namespace' => $namespace],
		function() {
			Route::post('authenticate', [
				'uses' => 'AdminController@authenticate'
			]);
			Route::post('add', [
				'uses' => 'AdminController@addItem'
			]);
		}
	);
});