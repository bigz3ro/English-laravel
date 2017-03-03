<?php 
$prefix = ""; //Prefix for url

$module = basename(__DIR__);
$namespace = "App\Modules\\{$module}\Controllers";

Route::group(
	["prefix" => $prefix, "module" => $module, "namespace" => $namespace ],
	function() use ($module){
		  Route::get('/', [
            # middle here
            "as" => "{$module}.index",
            "uses" => "{$module}Controller@index"
        ]);
	}
);