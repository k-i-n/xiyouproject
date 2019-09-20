<?php

namespace app\common\model;
use traits\model\SoftDelete;


class Experiences extends Model
{


  use SoftDelete;
  protected $name = 'experience';
  protected $autoWriteTimestamp = true;



}
