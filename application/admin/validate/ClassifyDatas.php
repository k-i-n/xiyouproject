<?php
/**
 * 后台数据分类子表验证类
 * @author yupoxiong<i@yufuping.com>
 */

namespace app\admin\validate;

class ClassifyDatas extends Admin
{
    protected $rule = [
        'name|主题名称'      => 'require',

    ];


}