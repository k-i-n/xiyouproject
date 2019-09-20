<?php
/**
 * 关于uMentor验证类
 * @author yupoxiong<i@yufuping.com>
 */

namespace app\admin\validate;

class Abouts extends Admin
{
    protected $rule = [
        'title|标题' => 'require',
        'description|内容' => 'require',
        'tutor|外籍文书导师' => 'require',
        'master|留学大咖' => 'require',
        'expert|翻译达人' => 'require',
    ];


}