<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetData extends Controller
{
    //
    public function __construct(){
    	$this->data = new \App\Model\dataCore();
    	date_default_timezone_set("Asia/Shanghai");
    }

    public function getData(Request $request){
    	$post = $request->json()->all();

    	$getDataParameter = array('classify', 'keys', 'values', 'page');

    	foreach ($getDataParameter as $key => $value) {
    		if (!isset($post[$value])) {
    			$error['code'] = '031';
    			$error['reason'] = 'Need more key : ' . $value;
    			return $error;
    		}
    	}
    	foreach ($post as $key => $value) {
    		if (!in_array($key, $getDataParameter)) {
    			$error['code'] = '032';
    			$error['reason'] = 'There\'s a illegal parameter : '.$key;
    			return $error;
    		}
    	}
        $page = ($post['page'] - 1) * 9; //如page = 1 则查询行号为 （1-1）* 9 = 0

    	switch ($post['classify']) {
    		case 'autoSearchDoctor':
    			foreach ($post['values'] as $key => $value) {
    				$like = isset($like) ? $like . " OR topic like '%$value%'" : "topic like '%$value%'";
    			}
				$sql = 'select id from doctor where '. $like;
				$doctorIds = json_decode(json_encode($this->data->sql($sql)), true);
				$doctorIds = $doctorIds == 0 ? array(0 => 1) : $doctorIds;
				foreach ($doctorIds as $markDown => $id) {
					$doctor = new \App\Model\doctor($id);
					$doctors[$markDown] = $doctor->getData();
				}
				// var_dump($doctors);
				return $doctors;
    			break;

            case 'searchDoctor':
                $sql = 'select id from doctor limit ' . $page . ',' . $page + 8;
                $doctorIds = json_decode(json_encode($this->data->sql($sql)), true);
                foreach ($doctorIds as $markDown => $id) {
                    $doctor = new \App\Model\doctor($id);
                    $doctors[$markDown] = $doctor->getData();
                }
                return $doctors;
                break;

    		case 'doctors':
    			foreach ($post['keys'] as $key => $value) {
                    $where = isset($where) ? $where . " and $value = $post['values'][$key]" : "$value = $post['values'][$key]"
                }
                $sql = 'select * from doctor where ' . $where . ' limit ' . $page . ',' . $page + 8;
                $doctor = json_decode(json_encode($this->data->sql($sql)), true);
                $doctor = $doctor == 0 ? NULL : $doctor;
                return $doctor;
                break;

    		case 'schedule':
    			$sql = 'select date from order where doctor = ' . $post['values'] . ' and status = 1 limit ' . $page . ',' . $page + 8;
    			$time = json_decode(json_encode($this->data->sql($sql)), true);
    			$time = $time == 0 ? NULL : $time;

    			return $time;
                break;

    		case 'allOrder':
    			$sql = 'select * from order limit ' . $page . ',' . $page + 8;
    			$orders = json_decode(json_encode($this->data->sql($sql)), true);
    			$orders = $orders == 0 ? NULL : $orders;
    			return $orders;
                break;

    		case 'searchOrder':
    			foreach ($post['keys'] as $key => $value) {
    				$where = isset($where) ? $where . " and $value = $post['values'][$key]" : "$value = $post['values'][$key]"
    			}
    			$sql = 'select * from order where ' . $where . ' limit ' . $page . ',' . $page + 8;
    			$orders = json_decode(json_encode($this->data->sql($sql)), true);
    			$orders = $orders == 0 ? NULL : $orders;
    			return $orders;
                break;
    		
    		default:
    			$error['code'] = 3;
    			$error['reason'] = "The classify cannt use for search";
    			return $error;
    			break;
    	}
    }
}
