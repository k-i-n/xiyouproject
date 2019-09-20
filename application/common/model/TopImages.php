<?php

namespace app\common\model;
use traits\model\SoftDelete;


class TopImages extends Model
{

  use SoftDelete;
  protected $name = 'image';
  protected $autoWriteTimestamp = true;


}
