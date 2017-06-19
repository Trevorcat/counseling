<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDO;

class dataCore extends Model
{
    //
    public function __construct(){

    }

    public function sql($sql){
    	$pdo = new PDO('mysql:host=123.206.226.28;dbname=counseling;port=3306','counseling','counseling@20170618');
        $pdo->exec('set names utf8');

        $sth = $pdo->prepare($sql);
        $sth->execute();

        $return = $sth->fetchAll(PDO::FETCH_CLASS);
        return $return == NULL ? 0 : $return;
    }

    public function insertData($table, $value){
        $success = DB::table($table)->insert($value) ? 1 : 0;
        return $success;
    }

    public function updateData($table, $value, $where){
        $success = DB::table($table)->where($where)->update($value) ? 1 : 0;
        return $success;
    }

}