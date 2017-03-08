<?php
namespace App\Modules\Admin\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Modules\Admin\Models\Admin;
use App\Http\Controllers\Controller;
use App\Helpers\ValidateTools;
use App\Helpers\Tools;
use App\Helpers\ResTools;


/*
Client gui theo gui theo fingerprint len 
- Server xac nhan user - password neu dung se sinh ra token tra 
  ve theo response Json
- Client lay toke trong response va luu xuong localStorage
*/

class AdminController extends Controller{
	public function __construct(){

	}
	public function authenticate(Request $request){
		$onlyFields = [ 'email', 'password' ];
		$checkRules = ValidateTools::checkRules(
			$request->all(),
			Admin::$fieldDescriptions,
			$onlyFields
		);
		if($checkRules){
			return response()->json($checkRules);
		}
		//Get input request and fingerprint 
		$email = $request->email;
		$password = $request->password;
		$fingerprint = $request->header('Fingerprint');
		// Get match email & password in DATABASE
		$result = Admin::authenticate( $email, $password , $fingerprint);
		// print_r($result);
		return response()->json($result);
		
	}

	
	public function addItem(Request $request){
		$input = ValidateTools::validateData(
			$request->all(),  Admin::$fieldDescriptions
		);
		// print_r($input);
		$result = Admin::addItem($input['success']?$input['data']:$input);
		return $result;
	}
	public function resetPassword(Request $request){
		$onlyFields = ['email', 'password'];
		$checkRules = ValidateTools::checkRules(
			$request->all(),
			Admin::$fieldDescriptions,
			$onlyFields
		);
		if($checkRules){
			return $checkRules;
		}
		
		$email = $request->input('email');
		$password = $request->input('password');
		$fingerprint = $request->header('Fingerprint');
        $result = Admin::resetPassword($email, $password, $fingerprint);
        return response()->json($result);
	}

}

