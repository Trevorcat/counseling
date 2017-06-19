<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Login extends Controller
{
    //
    public function __construct()
    {
    	$this->login = new \App\Model\dataCore();
    	date_default_timezone_set("Asia/Shanghai");
    }

    public function Login(Request $request){
    	$post = $request->json()->all();
    	$loginParameter = array('openId');

    	foreach ($loginParameter as $key => $value) {
    		if (!isset($post[$value])) {
    			$error['code'] = 1;
    			$error['reason'] = 'Need more key : ' . $value;
    			return $error;
    		}
    	}
    	foreach ($post as $key => $value) {
    		if (!in_array($key, $loginParameter)) {
    			$error['code'] = 2;
    			$error['reason'] = 'There\'s a illegal parameter : '.$key;
    			return $error;
    		}
    	}

    	$sql = "select * from customer where open_id = '" . $post['openId'] .'\'';
    	$count = $this->login->sql($sql);
    	if ($count == 0) {
    		$error['code'] = 3;
    		$error['reason'] = 'the customer need regist';
    		return $error;
    	}
    	$sucess['code'] = 0;
    	return $sucess;
    }
}
