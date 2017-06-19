<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['web']], function () {

	/**
	 * @param openId 用户openId
	 * 
	 * @return success 成功或失败 1/0
	 *
	 * 调用此接口进行登录，返回为1时进入下一个逻辑界面，返回为0是跳转注册界面
	 */
	Route::get('/login/',function(){
		return 'The API can not be used by the GET method';
	});
	Route::post('/login/','Login@Login');


	/**
	 * @param string open_id 用户openId
	 * @param string wechat_id 用户微信号
	 * @param string tel 用户手机号码（可以为空）
	 * @param string name 用户真实姓名（可以为空）
	 * @param string nick_name 昵称（可以使用微信昵称)
	 *
	 * @return array error['code'] = 1 或 2; error['reason'] 错误理由
	 * @return int success = 0 或 1 成功或失败
	 *
	 * 此接口用于注册使用，一般来说可以不用填写电话号码与真实姓名返回1为成功，0为失败
	 */
	Route::get('/register/',function(){
		return 'The API can not be used by the GET method';
	});
	Route::post('/register/','Register@register');

	/**
	 * @param int id 用户id
	 * @param string name 用户真实姓名
	 * @param string nick_name 用户昵称
	 * @param string tel 用户电话号码
	 *
	 * @return int success = 1 或 0 成功或失败
	 *
	 * 此接口用于用户修改信息或增加信息，每个字段均需要值，若为非修改字段，则传入原有值即可
	 */
	Route::get('/changedata/',function(){
		return 'The API can not be used by the GET method';
	});
	Route::post('/changedata/','Register@changeData');

	/**
	 * @param string classify 查询数据类型
	 * @param array keys 查询字段名
	 * @param array values 查询字段值
	 * @param int page 查询页数
	 *
	 * @return mix values 返回查询到的对应值
	 *
	 * classify = : 1、autoSearchDoctor 自动选择最佳医师，通过values中存放的标签，返回最匹配的医师
	 *				2、doctors 不需要keys和values字段，直接返回所有医师信息
	 *				3、searchDoctor 将需要查询的字段名放入keys数组中，对应字段值放入values数组中，
	 *				   返回符合条件的订单
	 *				4、schedule 通过values字段中的医师id返回该医师已被预约的时间
	 *				5、allOrder 不需要keys和values字段，直接返回所有订单信息
	 *				6、searchOrder 将需要查询的字段名放入keys数组中，对应字段值放入values数组中，
	 *				   返回符合条件的订单
	 */
	Route::get('/getdata/',function(){
		return 'The API can not be used by the GET method';
	});
	Route::post('/getdata/','GetData@getData');
});
