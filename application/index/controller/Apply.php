<?php

namespace app\index\controller;

use app\common\model\Applys;

class Apply extends Controller
{
    public function index(){
        $model = new Applys();
        $list = $model
            ->limit(8)
            ->select();

        $this->assign([
            'list'      => $list,
        ]);

        return $this->fetch();
    }
}
