<?php
/**
 * 后台数据分类验证类
 * @author yupoxiong<i@yufuping.com>
 */

namespace app\admin\validate;

class Classifys extends Admin
{
    protected $rule = [
        'pname|名称'      => 'require|unique:classify',

    ];


}