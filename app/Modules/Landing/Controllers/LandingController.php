<?php 
namespace App\Modules\Landing\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingController extends Controller{

	  public function __construct(){
        # parent::__construct();
    }

	public function index(Request $request){
		$data = [];
		return view("Landing::index", $data);
	}
}