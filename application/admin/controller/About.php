<?php

namespace app\admin\controller;

use app\common\model\Abouts;

class About extends Base
{
    public function index()
    {
        $model = new Abouts();
        $pageParam = ['query' => []];
        if (isset($this->param['keywords']) && !empty($this->param['keywords'])) {
            $pageParam['query']['keywords'] = $this->param['keywords'];
            $model->whereLike('title', "%" . $this->param['keywords'] . "%");
            $this->assign('keywords', $this->param['keywords']);
        }
        $list = $model
            ->order('id desc')
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
            if( !empty($_POST['tutor'])){
                $this->param['tutor'] =  stripslashes($_POST['tutor']);
            }
            if( !empty($_POST['master'])){
                $this->param['master'] =  stripslashes($_POST['master']);
            }
            if( !empty($_POST['expert'])){
                $this->param['expert'] =  stripslashes($_POST['expert']);
            }

            $result = Abouts::create($this->param);
            if ($result) {
                return $this->success();
            }
            return $this->error();
        }
        return $this->fetch();
    }

    public function edit()
    {
        $info = Abouts::get($this->id);
        if ($this->request->isPost()) {
            $resultValidate = $this->validate($this->param, 'Abouts.edit');
            if (true !== $resultValidate) {
                return $this->error($resultValidate);
            }

            if( !empty($_POST['description'])){
                $this->param['description'] =  stripslashes($_POST['description']);
            }
            if( !empty($_POST['tutor'])){
                $this->param['tutor'] =  stripslashes($_POST['tutor']);
            }
            if( !empty($_POST['master'])){
                $this->param['master'] =  stripslashes($_POST['master']);
            }
            if( !empty($_POST['expert'])){
                $this->param['expert'] =  stripslashes($_POST['expert']);
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
        $result = Abouts::destroy(function ($query) use ($id) {
            $query->whereIn('id', $id);
        });
        if ($result) {
            return $this->deleteSuccess();
        }
        return $this->error('删除失败');
    }
}
