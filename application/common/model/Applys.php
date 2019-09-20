<?php

namespace app\common\model;
use traits\model\SoftDelete;


class Applys extends Model
{


  use SoftDelete;
  protected $name = 'apply';
  protected $autoWriteTimestamp = true;



}
