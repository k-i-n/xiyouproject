<?php

namespace app\common\model;
use traits\model\SoftDelete;


class Evaluates1 extends Model
{


  use SoftDelete;
  protected $name = 'evaluate1';
  protected $autoWriteTimestamp = true;


}
