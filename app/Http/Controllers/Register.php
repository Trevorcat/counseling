<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Register extends Controller
{
    //
    public function __construct()
    {
    	$this->register = new \App\Model\dataCore();
    	date_default_timezone_set("Asia/Shanghai");
    }

    public function register(Request $request){
    	$post = $request->json()->all();

    	$registerParameter = array('open_id', 'wechat_id', 'tel', 'name', 'nick_name');

    	foreach ($registerParameter as $key => $value) {
            if ($value == 'tel' || $value == 'name') {
                continue;
            }
    		if (!isset($post[$value])) {
    			$error['code'] = '021';
    			$error['reason'] = 'Need more key : ' . $value;
    			return $error;
    		}
    	}
    	foreach ($post as $key => $value) {
    		if (!in_array($key, $registerParameter)) {
    			$error['code'] = '022';
    			$error['reason'] = 'There\'s a illegal parameter : '.$key;
    			return $error;
    		}
    	}

    	$insert = $this->register->insertData('customer', $post);

    	return $insert;
    }

    public function changeData(Request $request){
    	$post = $request->json()->all();

    	$changeParameter = array('id', 'name', 'nick_name', 'tel');

    	foreach ($changeParameter as $key => $value) {
    		if (!isset($post[$value])) {
    			$error['code'] = '023';
    			$error['reason'] = 'Need more key : ' . $value;
    			return $error;
    		}
    	}
    	foreach ($post as $key => $value) {
    		if (!in_array($key, $changeParameter)) {
    			$error['code'] = '024';
    			$error['reason'] = 'There\'s a illegal parameter : '.$key;
    			return $error;
    		}
    	}

    	$success = $this->register->updateData('customer', $post, $post['id']);
    	return $success;
    }
}
