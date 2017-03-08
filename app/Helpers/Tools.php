<?php
namespace App\Helpers;

use Mail;
use Carbon\Carbon;


class Tools {
	public static function r($data){
	    echo '<pre>';
	    print_r($data);
	    echo '</pre>';
	}
	// public static errMessage($err){
	// 	$errorMessage = $err->getMessage();
	// 	$errorLine = $err->getLine();
	// 	$errorFile = $err->getFile();
	// 	$message = $errorMessage. '=>'.$errorFile.' [line '.$errorLine.']';
	// 	if(\Config::get('app.debug')){
	// 		return $message;
	// 	}
	// 	self::sendErrorReport($message);
	// 	return trans('message.common_error');
	// }
	
	/*Return
		return response()->json([
		    'name' => 'Abigail',
		    'state' => 'CA'
		]);
	*/ 
	public static function jsonResponse($data){
		return response()->json($data);
	}

	//Learn later
	public static function parseOrderBy($input){
        // -ascii_title, ascii_title
        $order = 'desc';
        $field = 'id';
        if(!$input){
            return [$field, $order];
        }
        if(in_array($input[0], ['-', '+'])){
            if($input[0] === '-'){
                $order = 'desc';
            }else{
                $order = 'asc';
            }
            $field = substr($input, 1);
        }else{
            $order = 'asc';
            $field = $input;
        }
        return [$field, $order];
    }

	/* 
		:array return type declaration
		return [ 0 => key ];
	*/
	public static function getListKey(array $dataRules):array{
		// Tools::r($dataRules);
		$listKey = [];
		if($dataRules){
			foreach ($dataRules as $key => $value) {
				array_push($listKey, $key);
			}
		}
		// Tools::r($listKey);
		return $listKey;
	}
	
	public static function sendEmail($to, $subject, $template, $params=[], $attach=null){
    if(config('app.app_env') === 'testing'){
        return;
    }
    if(config('app.debug')){
        Mail::send($template, $params, function($m) use($to, $subject, $template, $params, $attach) {
            $from_email = \Config::get('app.from_email');
            $app_name = \Config::get('app.app_name');
            $m->from($from_email, $app_name);
            $m->to($to)->subject($subject);
            if($attach){
                $m->attach($attach);
            }
        });
    }else{
        Mail::queue($template, $params, function($m) use($to, $subject, $template, $params, $attach) {
            	$from_email = \Config::get('app.from_email');
            	$app_name = \Config::get('app.app_name');
            	$m->from($from_email, $app_name);
            	$m->to($to)->subject($subject);
            	if($attach){
                	$m->attach($attach);
            	}
        	});
    	}
	}
	public static function errMessage($err){
		 # var_dump($err);die;
        $errorMessage = $err->getMessage();
        $errorLine = $err->getLine();
        $errorFile = $err->getFile();
        $message = $errorMessage.' => '.$errorFile.' [line '.$errorLine.']';
        if(\Config::get('app.debug')){
            return $message;
        }
        self::sendErrorReport($message);
        return trans('messages.common_error');	
	}
	
    public static function sendErrorReport($errors){
        $subject = config('app.app_name').' - Error report';
        $params = [
            'errors' => print_r($errors, true)
        ];
        self::sendEmail(config('app.admin_email'), $subject, 'emails.errorReport', $params);
    }

    public static function nowDateTime(){
        return Carbon::now();
    }
}
