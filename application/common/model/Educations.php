<?php

namespace app\common\model;
use traits\model\SoftDelete;


class Educations extends Model
{


  use SoftDelete;
  protected $name = 'education';
  protected $autoWriteTimestamp = true;



}
