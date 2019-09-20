<?php

namespace app\index\controller;

use app\common\model\Problems;

class Problem extends Controller
{
    public function index()
    {
        $problems=new Problems();
        $list=$problems
            ->order('id asc')
            ->select();

        $this->assign([
            'list'      => $list,
        ]);

        return $this->fetch();
    }

}
