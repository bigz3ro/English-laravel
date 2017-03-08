<?php
namespace App\Modules\Atoken\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Tools;

class Atoken extends Model{

	public $timestamps = false;
	protected $table = 'tokens';
	protected $fillable = [
        'token',
        'user_id',
        'admin_id',
        'role',
        'role_type',
        'fingerprint'
    ];	
	protected $hidden = [
    ];

	public function parent(){
		return $this->belongsTo('App\Modules\Admin\Models\Admin', 'admin_id');
	}

	public static function newToken($id , $fingerprint, $role){
		//Remove token before
		$result = Atoken::where('admin_id', $id)->delete();
		$params = [
			'admin_id' => $id,
			'fingerprint' => $fingerprint
		];	
		Atoken::create($params);
		$item = Atoken::where('admin_id', $id)->first();
		return $item;
	}

	public function save(array $option = array()){
		$columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
		$this->created_at = Tools::nowDateTime();
		if(!$this->exists){
			$this->token = str_random(36);
			if(self::count() > 0){
				$largestIdItem = $this->orderBy('id', 'desc')->first()['id'];
				$this->id = $largestIdItem + 1;
			}else{
				$this->id = 1;
			}

			if(in_array('order', $columns)){
				$largestOrderItem = $this->orderBy('order', 'desc')->first();
				$order = 1;
				if($largestIdItem){
					$order = $largestOrderItem->order + 1;
				}
				$this->order = $order;
			}
		}
		parent::save();
	}

}