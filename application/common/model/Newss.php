<?php
/**
 * 留学资讯
 * @author yupoxiong<i@yufuping.com>
 */

namespace app\common\model;
use traits\model\SoftDelete;


class Newss extends Model
{


  use SoftDelete;
  protected $name = 'news';
  protected $autoWriteTimestamp = true;


  public function base()
  {
      return $this->belongsTo('classify_data', 'c_id', 'cid');
  }

}
