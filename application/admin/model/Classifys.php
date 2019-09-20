<?php
/**
 * 数据分类类
 * @author yupoxiong<i@yufuping.com>
 */

namespace app\admin\model;
use traits\model\SoftDelete;


class Classifys extends Admin
{
    use SoftDelete;
    protected $name = 'classify';
    protected $autoWriteTimestamp = true;


    public function ClassifyDatas()
  {
      return $this->belongsTo('classify_datas', 'pid', 'id');
  }

}
