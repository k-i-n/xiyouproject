<?php

namespace app\common\model;
use traits\model\SoftDelete;


class Evaluates extends Model
{


  use SoftDelete;
  protected $name = 'evaluate';
  protected $autoWriteTimestamp = true;

  public function user(){
      return $this->belongsTo('Users', 'user_id', 'id');
  }



}
