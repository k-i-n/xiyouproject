<?php
/**
 * 关于uMenter
 * @author yupoxiong<i@yufuping.com>
 */

namespace app\common\model;
use traits\model\SoftDelete;


class Abouts extends Model
{


  use SoftDelete;
  protected $name = 'about';
  protected $autoWriteTimestamp = true;



}
