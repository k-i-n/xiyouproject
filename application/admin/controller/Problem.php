<?php

namespace app\admin\controller;

use app\common\model\Problems;

class Problem extends Base
{
    public function index()
    {
        $problems = new Problems();
        $pageParam = ['query' => []];
        if (isset($this->param['keywords']) && !empty($this->param['keywords'])) {
            $pageParam['query']['keywords'] = $this->param['keywords'];
            $problems->whereLike('title', "%" . $this->param['keywords'] . "%");
            $this->assign('keywords', $this->param['keywords']);
        }
        $list = $problems
            ->order('id asc')
            ->paginate($this->webData['list_rows'], false, $pageParam);
        $this->assign([
            'list'      => $list,
            'total'     => $list->total(),
            'page'      => $list->render(),

        ]);
        return $this->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            if( !empty($_POST['description'])){
                $this->param['description'] =  stripslashes($_POST['description']);
            }

            $result = Problems::create($this->param);
            if ($result) {
                return $this->success();
            }
            return $this->error();
        }
        return $this->fetch();
    }

    public function edit()
    {
        $info = Problems::get($this->id);
        if ($this->request->isPost()) {
//            $resultValidate = $this->validate($this->param, 'Abouts.edit');
//            if (true !== $resultValidate) {
//                return $this->error($resultValidate);
//            }

            if( !empty($_POST['description'])){
                $this->param['description'] =  stripslashes($_POST['description']);
            }

            if (false !== $info->save($this->param)) {
                return $this->success();
            }
            return $this->error();

        }

        $this->assign([
            'info'         =>$info,
        ]);
        return $this->fetch('add');

    }

    public function del()
    {
        $id     = $this->id;
        $result = Problems::destroy(function ($query) use ($id) {
            $query->whereIn('id', $id);
        });
        if ($result) {
            return $this->deleteSuccess();
        }
        return $this->error('删除失败');
    }
}
