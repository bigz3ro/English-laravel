<?php
namespace App\Helpers;

use Validator;
use Carbon\Carbon;
use App\Helpers\Tools;

class ValidateTools {
	/*
	* Parse dataRequest -> array (key is rules(email|max: 100) & dataRules(str, int..))
	*
			Array
			(
			    [rules] => Array
			        (
			            [first_name] => required|max:70
			            [last_name] => required|max:70
			            [email] => required|email|max:100
			            [password] => max:100
			            [role] => max:20
			        )

			    [dataRules] => Array
			        (
			            [first_name] => str
			            [last_name] => str
			            [email] => str
			            [password] => str
			            [role] => str
			            [role_id] => int
			        )

			)
		
	*/
	//Parse 2 type rules
	public static function parseRules(array $fieldDescriptions){
		$result = [
			"rules" => [],
			"dataRules" => []
		];

		foreach($fieldDescriptions as $field => $rule){
			$ruleArr = explode(",", $rule);
			$result["dataRules"][$field] = $ruleArr[0];
			if(count($ruleArr) === 2){
				$result["rules"][$field] = $ruleArr[1];
			}
		}
		return $result;
	}

	// Get Rules(email|max:120)
	public static function getRules($rules, $listKey=[]){
		$resultKey = [];
		if(count($listKey)) {
			foreach($listKey as $key){
				if(array_key_exists($key, $rules)){
					$resultKey[$key] = $rules[$key];
				}
			}
		}
		if(count($resultKey)){
			return $resultKey;
		}
		return $rules;
	}
	
	/*
	* Validate rules (email|max:100) data of request 
	* Check rules -> if error return ResTools error code -> else return false (through)
	*/
	public static function checkRules($input, $fieldDescriptions, $onlyFields=[], $excludedFields=[]){
		
		$rules = self::parseRules($fieldDescriptions)["rules"];
		// print_r($rules);	
		$dataRules = self::parseRules($fieldDescriptions)["dataRules"];
		$finalRules = [];
		$fields = Tools::getListKey($dataRules);
		if(count($onlyFields)){
			$fields = $onlyFields;
		}
		foreach($fields as $field){
			if(!in_array($field, $excludedFields)){
				array_push($finalRules, $field);
			}
		}
		// print_r($finalRules);
		//Debug here
		$validator = Validator::make($input, self::getRules($rules, $finalRules));
		// print_r($validator);
		if($validator->fails()){
			return ResTools::err(
				$validator->errors(),
				ResTools::$ERROR_CODES['INTERNAL_SERVER_ERROR']
			);
		}
		return false;
	}
	
	//toJson
	public static function toJson($data){
		foreach ($data as $key => $dataItem) {
			try{
				if($data[$key]){
					$data[$key] = json_encode($dataItem);
				}else{
					$data[$key] = '""';
				}
			}catch(\Error $e){
				$data[$key] = '""';
			}
		}
		return $data;
	}
	
	//toStr
	public static function toStr($input, $default='') {
		try{
			if(gettype($input) === 'string'){
				$input = trim($input, '"');
				$input = trim($input, "'");
				if(in_array($input, ['null', 'Null', 'NULL'])){
					$input = '';
				}
			}else if(in_array(gettype($input), ['resource', 'object', 'array'])){
				$input = '';
			}
			return stripslashes($input);
		}catch(\Error $e){
			return $default;
		}
	}

	//toBool
	public static function toBool($input, $default=false) {
		try{
			$result = true;
			if(gettype($input) === 'string'){
				$input = trim($input, '"');
				$input = trim($input, "'");
				if(in_array($input, ['null', 'Null', 'NULL', '', 'false', 'False', 'FALSE'])){
					$result = false;
				}
			}else if(in_array(gettype($input), ['resource', 'object', 'array'])){
				if(gettype($input) === 'array'){
					if(!count($input)){
						$result = false;
					}
				}else{
					$result = true;
				}
			}else{
				if(!$input){
					$result = false;
				}
			}
			return $result;
		}catch(\Error $e){
			return $default;
		}
	}

	//toInt
	public static function toInt($input, $default=0) {
		try{
			if(gettype($input) === 'string'){
				$input = trim($input, '"');
				$input = trim($input, "'");
				if(in_array($input, ['null', 'Null', 'NULL', '', 'false', 'False', 'FALSE'])){
					$input = 0;
				}
			}else if(in_array(gettype($input), ['resource', 'object', 'array'])){
				$input = 0;
			}else{
				if(!$input){
					$input = 0;
				}
			}
			$result = intval($input);
			return $result;
		}catch(\Error $e){
			return $default;
		}
	}

	//toFloat
	public static function toFloat($input, $default=0.0) {
		try{
			if(gettype($input) === 'string'){
				$input = trim($input, '"');
				$input = trim($input, "'");
				if(in_array($input, ['null', 'Null', 'NULL', '', 'false', 'False', 'FALSE'])){
					$input = 0.0;
				}
			}else if(in_array(gettype($input), ['resource', 'object', 'array'])){
				$input = 0.0;
			}else{
				if(!$input){
					$input = 0.0;
				}
			}
			$result = floatVal($input);
			return $result;
		}catch(\Error $e){
			return $default;
		}
	}

	//toDate
	public static function toDate($input, $format = 'yearMonthDay') {
		# echo Carbon::createFromFormat('Y-m-d H', '1975-05-21 22')->toDateTimeString();
		if(!$input){
			return null;
		}
		try{
			if(gettype($input) === 'string'){
				$input = trim($input, '"');
				$input = trim($input, "'");
				if($format === 'yearMonthDay'){
					return Carbon::parse($input);
				}
				$input = explode(' ', $input)[0];
				return Carbon::createFromFormat($format, $input);
			}else{
				return null;
			}
		}catch(\Error $e){
			return null;
		}
	}	

	/**
	 * Validate $dataRules( str, int, ...)
	 * return Array 
	 * (
	 * 		[key] => value,
	 * 		[key] => value
	 * 		..............
	 * )
	 */
	public static function validateInput($input, $dataRules, $acceptedFields=[], $excludedFields=[]){
		// Tools::r($input);
		// Tools::r($dataRules);
		$result = [];
		$compactResult = [];
		foreach ($input as $field => $value) {
			foreach ($dataRules as $key => $type) {
					if($key === $field){
						switch($value){
							case 'str':
								$result[$field] = self::toStr($value);
								break;
							case 'int':
								$result[$field] = self::toInt($value);
								break;
							case 'float':
								$result[$field] = self::toFloat($value);
								break;
							case 'bool':
								$result[$field] = self::toBool($value);
								break;
							case 'data':
								$result[$field] = self::toDate($value);
								break;
							default:
								$result[$field] = self::toStr($value);
						}
					}
				}	
			}
			// Tools::r($result);
			if(count($acceptedFields) === 0){
				foreach ($result as $key => $value) {
					if(!in_array($key, $excludedFields)){
						$compactResult[$field] = $value;
					}
				}
				// r($compactResult);
				return $compactResult;
			}
			foreach ($result as $key => $value) {
				foreach ($acceptedFields as $field) {
					if($field === $key && !in_array($field, $excludedFields)){
						$compactResult[$field] = $value;
					}
				}
			}
			// Tools::r($compactResult);
			return $compactResult;
	}

	/*Data have two rule: 
					+ruleData ( str , int , float ....) 
					+rules ( email|max: 70)
	
	Final result =>  $errorCheck || $result
	*/
	public static function validateData($input, $fieldDescriptions, $onlyFields=[], $excludedFields=[]){
		$dataRules = self::parseRules($fieldDescriptions)["dataRules"];
		$result = ["success" => true, "data" => null];
		$errorCheck = self::checkRules($input, $fieldDescriptions, $onlyFields, $excludedFields);
		
		// Tools::r($errorCheck);

		if($errorCheck){
			$result = $errorCheck;
		}else{
			$result['success'] = true;
			$result['data'] = self::validateInput(
				$input,
				$dataRules,
				Tools::getListKey($dataRules),
				$excludedFields
			);
		}
		// Tools::r($result);
		return $result;
	}

	//Convert request params -> array
	public static function getFetchParams($allParams, $fillable){
		$keyword = null;
		$orderBy = '-id';
		$params = [];
		if(array_key_exists('keyword', $allParams)){
			$keyword = $allParams['keyword'];
		}
		if(array_key_exists('orderBy', $allParams)){
			$keyword = $allParams['orderBy'];
		}
		
		foreach ($allParams as $key => $value) {
			if(in_array($key, $fillable)){
				$params = $allParams[$key];
			}
		}

		$result = [
			'params' => $params,
			'keyword' => $keyword,
			'orderBy' => $orderBy
		];
		return $result;
	}

	//Convert request->all() params -> array
	public static function listInput($allParams, $model){
		$result = self::getFetchParams($allParams, $model->getFillable());
		return [
			$result['params'],
			$result['keyword'],
			$result['orderBy']
		];
	}
}