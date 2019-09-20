<?php

namespace app\admin\controller;

use think\Db;
use app\common\model\Attachments;
use app\common\model\Evaluates1;

class Evaluate1 extends Base
{
    public function index()
    {
        $model = new Evaluates1();
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
            if( !empty($_POST['comment'])){
                $this->param['comment'] =  stripslashes($_POST['comment']);
            }

            $result = Evaluates1::create($this->param);
            if ($result) {
                return $this->success();
            }
            return $this->error();
        }

        return $this->fetch();
    }

    public function edit()
    {
        $info = Evaluates1::get($this->id);
        if ($this->request->isPost()) {

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


            if( !empty($_POST['comment'])){
                $this->param['comment'] =  stripslashes($_POST['comment']);
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
        $result = Evaluates1::destroy(function ($query) use ($id) {
            $query->whereIn('id', $id);
        });
        if ($result) {
            return $this->deleteSuccess();
        }
        return $this->error('删除失败');
    }
}
