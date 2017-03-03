<?php
namespace App\Modules\Config\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Tools;
use App\Helpers\ResTools;


class Config extends Model{

	protected $table = 'configs';
	public $timestamps = false;

	protected $fillable = [
		'uid',
		'value'
	];

	protected $hidden = [
	];

	public static $fieldDescriptions = [
		'uid' => 'str,required|max:70',
		'value' => 'str,required|max:250',
	];

	public static $searchFields = ['uid', 'value'];

	public static function list($params=[], $keyword=null, $orderby='-id'){
		try{
			$orderBy = Tools::parseOrderBy($orderby);
			$listItem = Config::where($params);
			
			//Search keyword = where long nhau
			if($keyword && strlen($keyword) >= 3){
				$listItem = $listItem->where(function($query) use ($keyword){
					$query->orWhere($field, 'ilike', '%'.$keyword.'%');
				});
			}

			$listItem = $listItem->
						orderBy($orderBy[0], $orderBy[1])->
						paginate(config('app.page_size'));
			// var_dump(ResTools::lst($listItem));
			return ResTools::lst($listItem);
		}
		catch(\Exception $e){
			return $e;
		}		
	}
}
