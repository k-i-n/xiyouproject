<?php
/**
 * 留学资讯
 * @author yupoxiong<i@yufuping.com>
 */

namespace app\common\model;
use traits\model\SoftDelete;


class Teachers extends Model
{


  use SoftDelete;
  protected $name = 'teacher';
  protected $autoWriteTimestamp = true;

  public function school()
   {
      return $this->belongsTo('classify_data', 'serviceschool', 'cid');
   }

  public function area()
  {
      return $this->belongsTo('classify_data', 'servicearea', 'cid');
  }
  public function major()
  {
      return $this->belongsTo('classify_data', 'servicemajor', 'cid');
  }
  public function cou(){
      return $this->belongsTo('classify_data', 'counselor', 'cid');
  }
  public function app(){
      return $this->belongsTo('classify_data', 'apply', 'cid');
  }


}
