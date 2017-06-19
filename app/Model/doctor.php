<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class doctor extends Model
{
    //
    public $id;

    public $wechat_id;

    public $avatar;

    public $name;

    public $describe;

    public $topic;

    public $trainingInfo;

    public $workingInfo;

    public function __construct($id){
    	$this->datas = new \App\Model\dataCore();
    	$sql = 'select * from doctor where id = ' . $id;
    	$data = $this->datas->sql($sql);

    	if ($data == 0) {
    		return NULL;
    	}
    	$data = $data[0];
    	$this->id = $data->id;
    	$this->wechat_id = $data->wechat_id;
    	$this->avatar = $data->avatar;
    	$this->describe = $data->describe;
    	$this->topic = $data->topic;

    	$sql = 'select * from doctor_training_info where doctor_id = ' . $this->id;
    	$this->trainingInfo = $this->datas->sql($sql);

    	$sql = 'select * from doctor_working_info where doctor_id = ' . $this->id;
    	$this->workingInfo = $this->datas->sql($sql);

    	return $this;
    }

    public function getData(){
    	$data['id'] = $this->id;
    	$data['wechat_id'] = $this->wechat_id;
    	$data['avatar'] = $this->avatar;
    	$data['name'] = $this->name;
    	$data['describe'] = $this->describe;
    	$data['topic'] = $this->topic;
    	$data['trainingInfo'] = json_decode(json_encode($this->trainingInfo), true);
    	$data['workingInfo'] = json_decode(json_encode($this->workingInfo), true);
    	return $data;
    }
}
