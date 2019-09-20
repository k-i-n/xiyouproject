<?php
/**
 * 留学资讯
 * @author yupoxiong<i@yufuping.com>
 */

namespace app\admin\controller;
use think\Db;
use app\common\model\Attachments;
use app\common\model\Newss;

class News extends Base
{
    public function index()
    {
        $model = new Newss();
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
            $file                    = $attachment->upload('newsimage');
            if ($file) {
                $this->param['newsimage'] = $file->url;
            }else{
                return $this->error($attachment->getError());
            }
            if( !empty($_POST['content'])){
              $this->param['content'] =  stripslashes($_POST['content']);
             }

            $result = Newss::create($this->param);
            if ($result) {
                return $this->success();
            }
            return $this->error();
        }
          $turntype = Db::name('classify')
              ->alias('a')
              ->join('classify_data b','a.id = b.pid')
              ->field('a.id,a.pname,b.cid,b.name')
              ->where('a.id',1)
              ->where('b.delete_time','null')
              ->select();
          $this->assign([
                      'turntype'  => $turntype,
                  ]);
          return $this->fetch();
     }

 public function edit()
    {
        $info = Newss::get($this->id);
        if ($this->request->isPost()) {
            $resultValidate = $this->validate($this->param, 'Newss.edit');
            if (true !== $resultValidate) {
                return $this->error($resultValidate);
            }
            if ($this->request->file('newsimage')) {
                $attachment = new Attachments();
                $file       = $attachment->upload('newsimage');
                if ($file) {
                    $this->param['newsimage'] = $file->url;
                } else {
                    return $this->error($attachment->getError());
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
        $turntype = Db::name('classify')
                    ->field('a.id,a.pname,b.cid,b.name')
                    ->alias('a')
                    ->join('classify_data b','a.id = b.pid')
                    ->where('a.id',1)
                    ->where('b.delete_time','null')
                    ->select();

         $this->assign([
            'info'      => $info,
            'turntype'  => $turntype,
        ]);
        return $this->fetch('add');
    }




    public function del()
    {
        $id     = $this->id;
        $result = Newss::destroy(function ($query) use ($id) {
            $query->whereIn('id', $id);
        });
        if ($result) {
            return $this->deleteSuccess();
        }
        return $this->error('删除失败');
    }




}