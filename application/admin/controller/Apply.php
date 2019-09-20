<?php

namespace app\admin\controller;

use think\Db;
use app\common\model\Attachments;
use app\common\model\Applys;

class Apply extends Base
{
    public function index()
    {
        $model = new Applys();
        $pageParam = ['query' => []];
        if (isset($this->param['keywords']) && !empty($this->param['keywords'])) {
            $pageParam['query']['keywords'] = $this->param['keywords'];
            $model->whereLike('title', "%" . $this->param['keywords'] . "%");
            $this->assign('keywords', $this->param['keywords']);
        }
        $list = $model
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
            $attachment              = new Attachments();
            $file                    = $attachment->upload('image');
            if ($file) {
                $this->param['image'] = $file->url;
            }else{
                return $this->error($attachment->getError());
            }
            if( !empty($_POST['content'])){
                $this->param['content'] =  stripslashes($_POST['content']);
            }

            $result = Applys::create($this->param);
            if ($result) {
                return $this->success();
            }
            return $this->error();
        }

        return $this->fetch();
    }

    public function edit()
    {
        $info = Applys::get($this->id);
        if ($this->request->isPost()) {
//            $resultValidate = $this->validate($this->param, 'Teachers.edit');
//            if (true !== $resultValidate) {
//                return $this->error($resultValidate);
//            }
            if ($this->request->file('image')) {
                $attachment = new Attachments();
                $file       = $attachment->upload('image');
                $this->param['image'] = $file->url;
                if ($file) {
                    $this->param['image'] = $file->url;
                } else {
                    $this->param['image'] = "";
                }
            }

            if( !empty($_POST['content'])){
                $this->param['content'] =  stripslashes($_POST['content']);
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
        $result = Applys::destroy(function ($query) use ($id) {
            $query->whereIn('id', $id);
        });
        if ($result) {
            return $this->deleteSuccess();
        }
        return $this->error('删除失败');
    }
}
