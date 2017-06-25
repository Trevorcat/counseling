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
    			$error['code'] = '011';
    			$error['reason'] = 'Need more key : ' . $value;
    			return $error;
    		}
    	}
    	foreach ($post as $key => $value) {
    		if (!in_array($key, $loginParameter)) {
    			$error['code'] = '012';
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

    public function getOpenId(Request $request){
        $post = $request->json()->all();

        $inputParameter = array('code');

        foreach ($loginParameter as $key => $value) {
            if (!isset($post[$value])) {
                $error['code'] = '013';
                $error['reason'] = 'Need more key : ' . $value;
                return $error;
            }
        }
        foreach ($post as $key => $value) {
            if (!in_array($key, $loginParameter)) {
                $error['code'] = '014';
                $error['reason'] = 'There\'s a illegal parameter : '.$key;
                return $error;
            }
        }

        $curl=curl_init(); 
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1); 
        curl_setopt($curl,CURLOPT_HEADER,0 ) ;
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=wx16ed6d71ca66500d&secret=e2e57713307a0001e142a197902e376d&js_code=' . $post['code'] . '&grant_type=authorization_code'; 
        curl_setopt($curl,CURLOPT_URL,$url);
        $result=curl_exec($curl); 
        curl_close($curl);

        return $result;
    }

}
