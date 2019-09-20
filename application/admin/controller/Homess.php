<?php

namespace app\admin\controller;

use app\common\model\BottomImages;
use app\common\model\Attachments;
use think\Request;

class Homess extends Base
{
    public function index()
    {
        $model = new BottomImages();
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
            $file                    = $attachment->upload('logo');
            if ($file) {
                $this->param['logo'] = $file->url;
            }else{
                return $this->error($attachment->getError());
            }

            $result = BottomImages::create($this->param);
            if ($result) {
                return $this->success();
            }
            return $this->error();
        }

        return $this->fetch();
    }

    public function edit()
    {
        $info = BottomImages::get($this->id);
        if ($this->request->isPost()) {
            if ($this->request->file('logo')) {
                $attachment = new Attachments();
                $file       = $attachment->upload('logo');
                $this->param['logo'] = $file->url;
                if ($file) {
                    $this->param['logo'] = $file->url;
                } else {
                    $this->param['logo'] = "";
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
        $result = BottomImages::destroy(function ($query) use ($id) {
            $query->whereIn('id', $id);
        });
        if ($result) {
            return $this->deleteSuccess();
        }
        return $this->error('删除失败');
    }
}
