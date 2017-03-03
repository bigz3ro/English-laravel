<?php
namespace App\Modules\Config\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Modules\Config\Models\Config;
use App\Http\Controllers\Controller;
use App\Helpers\ValidateTools;
use App\Helpers\Tools;
use App\Helpers\ResTools;

class ConfigController extends Controller{
	public function __construct(){

	}
	public function index(){
		
	}

	public function list(Request $request){
		$input = ValidateTools::listInput($request->all(), new Config);
		// print_r($input);
		$result = Config::list(...$input);
		return Tools::jsonResponse($result);
	}

	public function obj(){

	}
	public function edit(){
		
	}
}