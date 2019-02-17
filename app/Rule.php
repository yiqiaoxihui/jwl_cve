<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{

    public function Scan(){
    	return $this->hasMany('App\Scan','rule_id');
    }
    // /*与文件还原记录一对多关系*/
    // public function fileRestoreRecords(){
    // 	return $this->hasMany('App\FileRestoreRecord','fileId');
    // }
}
