<?php

namespace app\common\model;
use traits\model\SoftDelete;


class Cases extends Model
{

  use SoftDelete;
  protected $name = 'case';
  protected $autoWriteTimestamp = true;

    //录取院校关联
    public function school()
    {
        return $this->belongsTo('classify_data', 'school1', 'cid');
    }

    //专业大类关联
    public function major()
    {
        return $this->belongsTo('classify_data', 'major_chief', 'cid');
    }

    //地区关联
    public function area()
    {
        return $this->belongsTo('classify_data', 'region', 'cid');
    }

}
