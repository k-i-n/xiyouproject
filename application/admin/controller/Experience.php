<?php

namespace app\admin\controller;

use app\common\model\Experiences;
use app\common\model\Attachments;

class Experience extends Base
{
    public function index()
    {
        $model = new Experiences();
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
            $file1                    = $attachment->upload('image');
            if ($file1) {
                $this->param['image'] = $file1->url;
            }else{
                return $this->error($attachment->getError());
            }

            $file2                    = $attachment->upload('photo');
            if ($file2) {
                $this->param['photo'] = $file2->url;
            }else{
                return $this->error($attachment->getError());
            }

            if( !empty($_POST['content'])){
                $this->param['content'] =  stripslashes($_POST['content']);
            }

            $result = Experiences::create($this->param);
            if ($result) {
                return $this->success();
            }
            return $this->error();
        }

        return $this->fetch();
    }

    public function edit()
    {
        $info = Experiences::get($this->id);
        if ($this->request->isPost()) {
            if ($this->request->file('image')) {
                $attachment = new Attachments();
                $file1       = $attachment->upload('image');
                $this->param['image'] = $file1->url;
                if ($file1) {
                    $this->param['image'] = $file1->url;
                } else {
                    $this->param['image'] = "";
                }
            }

            if ($this->request->file('photo')) {
                $attachment = new Attachments();
                $file2       = $attachment->upload('phone_image');
                $this->param['photo'] = $file2->url;
                if ($file2) {
                    $this->param['photo'] = $file2->url;
                } else {
                    $this->param['photo'] = "";
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
        $result = Experiences::destroy(function ($query) use ($id) {
            $query->whereIn('id', $id);
        });
        if ($result) {
            return $this->deleteSuccess();
        }
        return $this->error('删除失败');
    }

}
