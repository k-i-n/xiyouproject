<?php

namespace app\admin\controller;

use app\common\model\TopImages;
use app\common\model\Attachments;
use think\Controller;
use think\Request;

class Homes extends Base
{

    public function index()
    {
        $model = new TopImages();
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
            $file1                    = $attachment->upload('pc_image');
            if ($file1) {
                $this->param['pc_image'] = $file1->url;
            }else{
                return $this->error($attachment->getError());
            }

            $file2                    = $attachment->upload('phone_image');
            if ($file2) {
                $this->param['phone_image'] = $file2->url;
            }else{
                return $this->error($attachment->getError());
            }

            $result = TopImages::create($this->param);
            if ($result) {
                return $this->success();
            }
            return $this->error();
        }

        return $this->fetch();
    }

    public function edit()
    {
        $info = TopImages::get($this->id);
        if ($this->request->isPost()) {
            if ($this->request->file('pc_image')) {
                $attachment = new Attachments();
                $file1       = $attachment->upload('pc_image');
                $this->param['pc_image'] = $file1->url;
                if ($file1) {
                    $this->param['pc_image'] = $file1->url;
                } else {
                    $this->param['pc_image'] = "";
                }
            }

            if ($this->request->file('phone_image')) {
                $attachment = new Attachments();
                $file2       = $attachment->upload('phone_image');
                $this->param['phone_image'] = $file2->url;
                if ($file2) {
                    $this->param['phone_image'] = $file2->url;
                } else {
                    $this->param['phone_image'] = "";
                }
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
        $result = TopImages::destroy(function ($query) use ($id) {
            $query->whereIn('id', $id);
        });
        if ($result) {
            return $this->deleteSuccess();
        }
        return $this->error('删除失败');
    }
}
