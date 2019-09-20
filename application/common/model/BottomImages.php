<?php

namespace app\common\model;
use traits\model\SoftDelete;


class BottomImages extends Model
{

  use SoftDelete;
  protected $name = 'bottomimage';
  protected $autoWriteTimestamp = true;


}
