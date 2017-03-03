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
		
	}

	
	public function addItem(Request $request){
		$input = ValidateTools::validateData(
			$request->all(),  Admin::$fieldDescriptions
		);

		return $input;
	}
}

