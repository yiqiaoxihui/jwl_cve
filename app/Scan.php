<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    //
    //protected $table = 'fileScanRecord';
    //全盘扫描与增量镜像一对多关系
    public function rule(){
    	return $this->belongsTo('App\Rule','rule_id');
    }
}
