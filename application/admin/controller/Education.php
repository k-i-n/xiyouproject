<?php

namespace app\admin\controller;

use app\common\model\Educations;
use app\common\model\Attachments;

class Education extends Base
{
    public function index(){
        $id=$this->id;
        $model=new Educations();
        $pageParam['query']['id'] = $id;
        $list = $model
            ->where('t_id',$id)
            ->paginate($this->webData['list_rows'], false, $pageParam);
        $this->assign([
            't_id'      => $id,
            'list'      => $list,
            'total'     => $list->total(),
            'page'      => $list->render(),

        ]);
        return $this->fetch();
    }

    public function add()
    {
        $t_id = request()->get('t_id');
        if ($this->request->isPost()) {
            $attachment              = new Attachments();
            $file                    = $attachment->upload('logo');
            if ($file) {
                $this->param['logo'] = $file->url;
            }else{
                return $this->error($attachment->getError());
            }

            $this->param['t_id'] = $t_id;
            $result = Educations::create($this->param);
            if ($result) {
                return $this->success();
            }
            return $this->error();
        }

        return $this->fetch();
    }

    public function edit()
    {
        $info = Educations::get($this->id);
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
        $result = Educations::destroy(function ($query) use ($id) {
            $query->whereIn('id', $id);
        });
        if ($result) {
            return $this->deleteSuccess();
        }
        return $this->error('删除失败');
    }
}
