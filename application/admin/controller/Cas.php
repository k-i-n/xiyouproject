<?php

namespace app\admin\controller;

use think\Db;
use app\common\model\Attachments;
use app\common\model\Cases;

class Cas extends Base
{
    public function index()
    {
        $model = new Cases();
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
            $file                    = $attachment->upload('offer');
            if ($file) {
                $this->param['offer'] = $file->url;
            }else{
                return $this->error($attachment->getError());
            }


            $result = Cases::create($this->param);
            if ($result) {
                return $this->success();
            }
            return $this->error();
        }
        //高校
        $school = Db::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',5)
            ->where('b.delete_time','null')
            ->select();

        //专业大类
        $major = Db::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',3)
            ->where('b.delete_time','null')
            ->select();

        //地区
        $area=Db::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',2)
            ->where('b.delete_time','null')
            ->select();
        $this->assign([
            'school'  => $school,
            'major' => $major,
            'area' => $area,
        ]);
        return $this->fetch();
    }

    public function edit()
    {
        $info = Cases::get($this->id);
        if ($this->request->isPost()) {
            if ($this->request->file('offer')) {
                $attachment = new Attachments();
                $file       = $attachment->upload('offer');
                $this->param['offer'] = $file->url;
                if ($file) {
                    $this->param['offer'] = $file->url;
                } else {
                    $this->param['offer'] = "";
                }
            }

            if (false !== $info->save($this->param)) {
                return $this->success();
            }
            return $this->error();

        }
        //高校
        $school = Db::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',5)
            ->where('b.delete_time','null')
            ->select();

        //专业大类
        $major = Db::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',3)
            ->where('b.delete_time','null')
            ->select();

        //地区
        $area=Db::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',2)
            ->where('b.delete_time','null')
            ->select();

        $this->assign([
            'info'         =>$info,
            'school'  => $school,
            'major' => $major,
            'area' => $area,
        ]);
        return $this->fetch('add');

    }

    public function del()
    {
        $id     = $this->id;
        $result = Cases::destroy(function ($query) use ($id) {
            $query->whereIn('id', $id);
        });
        if ($result) {
            return $this->deleteSuccess();
        }
        return $this->error('删除失败');
    }
}
