<?php

namespace app\admin\controller;

use think\Request;
use app\common\model\Evaluates;

class Evaluate extends Base
{
    public function index(){
        $id=$this->id;
        $model=new Evaluates();
        $pageParam['query']['id'] = $id;
        $list = $model
            ->where('teacher_id',$id)
            ->paginate($this->webData['list_rows'], false, $pageParam);
        $this->assign([
            'list'      => $list,
            'total'     => $list->total(),
            'page'      => $list->render(),

        ]);
        return $this->fetch();
    }

    public function del()
    {
        $id     = $this->id;
        $result = Evaluates::destroy(function ($query) use ($id) {
            $query->whereIn('id', $id);
        });
        if ($result) {
            return $this->deleteSuccess();
        }
        return $this->error('删除失败');
    }
}
