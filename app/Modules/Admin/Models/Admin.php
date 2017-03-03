<?php 
namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Tools;
use App\Helpers\ResTools;

//Fix here (extends Authenticate)
class Admin extends Model{

	protected $table = 'admins';
	public $timestamps = false;

	protected $fillable = [
		'first_name',
		'last_name',
		'password',
		'email',
		'permissions'
	];
	
	protected $hidden = [
		'password',
		'fingerprint',
		'remember_token',
		'change_password_token',
		'change_password_token_created',
		'change_password_token_tmp',
		'reset_password_token',
		'reset_password_token_created',
		'reset_password_token_tmp',
		'signup_token',
		'signup_token_created',
		'created_at',
		'updated_at',
		'permissions'
	];

	public static $fieldDescriptions = [
		'first_name' => 'str,required|max:70',
		'last_name' => 'str,required|max:70',
		'email' => 'str,required|email|max:100',
		'password' => 'str,max:100',
		'role' => 'str,max:20',
		'role_id' => 'int'
	];

	public static $searchFields = ['first_name', 'last_name','email'];
	
}