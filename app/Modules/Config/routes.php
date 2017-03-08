<?php
Route::group(['prefix' => 'api/v1/', 'middleware' => 'api'], function(){
	$namespace = 'App\Modules\Config\Controllers';
	Route::group(
		['prefix' => 'config', 'module'=>'Config', 'namespace' => $namespace],
		function() {
			Route::get('list', [
				'as' => 'list',
				'uses' => 'ConfigController@list'
			]);
			Route::get('obj', [
				'middleware' => 'token_required',
				'as' => 'obj',
				'uses' => 'ConfigController@obj'
			]);
			Route::post('add', [
				'middleware' => 'token_required',
				'as' => 'addItem',
				'uses' => 'ConfigController@addItem'
			]);
			Route::post('edit', [
				'middleware' => 'token_required',
				'as' => 'editItem',
				'uses' => 'ConfigController@editItem'
			]);
			Route::post('remove', [
				'middleware' => 'token_required',
				'as' => 'removeItem',
				'uses' => 'ConfigController@removeItem'
			]);
			Route::get('rate', [
				'as' => 'rate',
				'uses' => 'ConfigController@rate'
			]);
		}
	);
});