<?php
/**
 * 数据分类子表类
 * @author yupoxiong<i@yufuping.com>
 */

namespace app\admin\model;
use traits\model\SoftDelete;


class ClassifyDatas extends Admin
{
    use SoftDelete;
    protected $name = 'classifyData';
    protected $autoWriteTimestamp = true;


}
