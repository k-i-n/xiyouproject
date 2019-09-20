<?php
/**
 * 常见问题
 */

namespace app\common\model;
use traits\model\SoftDelete;


class Problems extends Model
{


  use SoftDelete;
  protected $name = 'problem';
  protected $autoWriteTimestamp = true;



}
