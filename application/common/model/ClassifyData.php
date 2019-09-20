<?php
/**
 * 数据分类子表类
 * @author yupoxiong<i@yufuping.com>
 */

namespace app\common\model;
use traits\model\SoftDelete;


class ClassifyData extends Model
{
    use SoftDelete;
    protected $name = 'classifyData';
    protected $autoWriteTimestamp = true;


}
