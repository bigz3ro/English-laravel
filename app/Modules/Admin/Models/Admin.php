<?php 
namespace App\Modules\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Tools;
use App\Helpers\ResTools;
use App\Modules\Atoken\Models\Atoken;
use Auth;
use Carbon\Carbon;

//Fix here (extends Authenticate)
class Admin extends Authenticatable {

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
	//1 - n
	public function token(){
		return $this->hasMany('App\Modules\Atoken\Models\Atoken', 'admin_id');
	}

	public static function addItem($input){
		try{
			// print_r($input);
			/**
			 * 1. check status code !== 200 && $input['success'] exist => if false => return $input
			 * 2. Check username - password duplicate
			 * 3. if False return Message error
			 * 4. if True send Mail for change password ( with set password random )
			 * 5. Return RestAPI
			 */
			if(array_key_exists('success', $input) && array_key_exists('status_code', $input) && 
				$input['status_code'] !== 200 ){
				return $input;
			}

			$checkEmail = self::where(["email" => $input["email"]])->first();
			if($checkEmail){
				return ResTools::err(
					trans('messages.duplicate_email'),
					ResTools::$ERROR_CODES['BAD_REQUEST']
				);
			}
			$input["password"] = \Hash::make(str_random(config('app.random_size')));
			// $role = Role::find(intVal($input['role_id']));
			// $input["permissions"] = "abc";
			// $input["role"] = 123;
			$item = self::create($input);
			
			#Send mail here
			$clientResetPassword = config('app.client_admin_url');
			$to = $item->email;
			$subject = 'Account for '.$item->last_name. ' created.';
			$params = [
				'clientResetPasswordUrl' => $clientResetPassword,
				'last_name' => $item->last_name
			];
			Tools::sendEmail($to, $subject, 'emails.signup', $params);
			// $item->role;
			return ResTools::obj($item, 'HELLO');
		}
		catch(\Exception $e){return $e;}
		catch(\Error $e){return $e;}
	}

	public static function authenticate($email, $password, $fingerprint){
		// Match $email , password
		try{
				if(Auth::guard('admin')->attempt(['email' => $email, 'password' => $password])){		
					$user = self::where('email', $email)->first();
					//Get new token
					$token = Atoken::newToken($user->id, $fingerprint);
					//Compare token user with token in tokenTable
					$user->token = $token->token;
					$result = [
						'first_name' => $user->first_name,
						'last_name' => $user->last_name,
						'email' => $user->email,
						'role' => $user->role,
						'token' => $user->token
					];
					// print_r($result);
					return ResTools::obj($result, trans('auth.authenticate_success'));
			}
		}catch(\Error $e){
			return ResTools::err($e->getMessage(),ResTools::$ERROR_CODES['UNAUTHORIZED']);
		}
	}

	//Reset password
	public static function resetPassword($email, $password, $fingerprint){
		//Start update email password to Admin model
		try{
			$item = Admin::where('email', $email)->first();
			if(!$item){
				return ResTools::obj([], trans('auth.reset_password_success'));
			}
			$clientResetPasswordUrl = \Config::get('app.client_admin_url').'reset_password_confirm/reset/';
			if($password){
				$item->reset_password_token_created = Carbon::now();
				$item->reset_password_token_tmp = \Hash::make($password);
				$item->reset_password_token = Atoken::newToken($item->id, $fingerprint, $item->role)->token;
				$item->save();
				$clientResetPasswordUrl.=$item->reset_password_token;
				#Send mail here
				$to = $item->email;
				$subject = "Reset password for ".$item->last_name;
				$params = [
					'clientResetPasswordUrl' => $clientResetPasswordUrl,
					'last_name' => $item->last_name
				];
				Tools::sendEmail($to, $subject, 'emails.resetPassword', $params);
				return ResTools::obj([], trans('auth.reset_password_success'));
			}else{
				return ResTools::err(
					trans('auth.password_can_not_be_null'),
					ResTools::$ERROR_CODES['BAD_REQUEST']
				);
			}
		}
		catch(\Exception $e){ 
			return ResTools::criticalErr(Tools::errMessage($e));
		}
		catch(\Error $e){ 
			return ResTools::criticalErr(Tools::errMessage($e));
		}
	}
	
	public function save(array $option = array()){
		#auto increase order (if order exist)
		#get colomn table
		$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
		if(in_array('update_at' , $columns)){
			$this->update_at = Tools::nowDateTime();
		}
		if(!$this->exists){
			if(in_array('created_at', $columns)){
				$this->created_at = Tools::nowDateTime();
			}
			if(self::count() > 0){
				$largestIdItem = self::orderBy('id', 'desc')->first();
				$this->id = $largestIdItem->id + 1;
			}else{
				$this->id = 1;
			}
			if(in_array('order', $columns)){
				if($this->order === 0){
					$largestOrderItem = self::orderBy('order', 'desc')->first();
					if($largestIdItem){
						$this->order = $largestOrderItem->order + 1;
					}else{
						$this->order = 1;
					}
				}
			}
		}
		parent::save();
	}
}