<?php

namespace app\index\controller;

use think\Request;
use app\common\model\Abouts;

class About extends Controller
{
    public function index(){
        $model = new Abouts();
        $list = $model
            ->order('id desc')
            ->find();
        $this->assign([
            'item'      => $list,
        ]);

        return $this->fetch();
    }
}
