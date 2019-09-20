<?php
/**
 * 导师展示
 * @author yupoxiong<i@yufuping.com>
 */

namespace app\admin\controller;
use think\Db;
use app\common\model\Attachments;
use app\common\model\Teachers;

class Teacher extends Base
{
    public function index()
    {
        $model = new Teachers();
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
            $file                    = $attachment->upload('headimg');
            if ($file) {
                $this->param['headimg'] = $file->url;
            }else{
                return $this->error($attachment->getError());
            }
            if( !empty($_POST['introduction'])){
              $this->param['introduction'] =  stripslashes($_POST['introduction']);
             }
             if( !empty($_POST['specialservice'])){
              $this->param['specialservice'] =  stripslashes($_POST['specialservice']);
             }

            $result = Teachers::create($this->param);
            if ($result) {
                return $this->success();
            }
            return $this->error();
        }
        //学校
        $serviceschool = Db::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('a.id,a.pname,b.cid,b.name')
            ->where('a.id',5)
            ->where('b.delete_time','null')
            ->select();
         //地区
          $servicearea = Db::name('classify')
              ->alias('a')
              ->join('classify_data b','a.id = b.pid')
              ->field('a.id,a.pname,b.cid,b.name')
              ->where('a.id',2)
              ->where('b.delete_time','null')
              ->select();
          //专业
          $servicemajor = Db::name('classify')
              ->alias('a')
              ->join('classify_data b','a.id = b.pid')
              ->field('a.id,a.pname,b.cid,b.name')
              ->where('a.id',3)
              ->where('b.delete_time','null')
              ->select();
          //顾问学位
          $guwen=Db::name('classify')
              ->alias('a')
              ->join('classify_data b','a.id = b.pid')
              ->field('b.cid,b.name')
              ->where('a.id',4)
              ->where('b.delete_time','null')
              ->select();
        //申请学位
        $shenqing=Db::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',6)
            ->where('b.delete_time','null')
            ->select();

          $this->assign([
                      'serviceschool'  => $serviceschool,
                      'servicearea'  => $servicearea,
                      'servicemajor' => $servicemajor,
                      'guwen' => $guwen,
                      'shenqing' => $shenqing,
                  ]);
          return $this->fetch();
     }

    public function edit()
    {
        $info = Teachers::get($this->id);
        if ($this->request->isPost()) {
            $resultValidate = $this->validate($this->param, 'Teachers.edit');
            if (true !== $resultValidate) {
                return $this->error($resultValidate);
            }
            if ($this->request->file('headimg')) {
              $attachment = new Attachments();
              $file       = $attachment->upload('headimg');
              $this->param['headimg'] = $file->url;
              if ($file) {
                  $this->param['headimg'] = $file->url;
              } else {
                 $this->param['headimg'] = "";
              }
            }

            if( !empty($_POST['introduction'])){
              $this->param['introduction'] =  stripslashes($_POST['introduction']);
             }
             if( !empty($_POST['specialservice'])){
              $this->param['specialservice'] =  stripslashes($_POST['specialservice']);
             }
            if (false !== $info->save($this->param)) {
                return $this->success();
            }
            return $this->error();

      }
        //学校
        $serviceschool = Db::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('a.id,a.pname,b.cid,b.name')
            ->where('a.id',5)
            ->where('b.delete_time','null')
            ->select();

        //服务地区
        $servicearea = Db::name('classify')
        ->field('a.id,a.pname,b.cid,b.name')
        ->alias('a')
        ->join('classify_data b','a.id = b.pid')
        ->where('a.id',2)
        ->where('b.delete_time','null')
        ->select();
        //服务专业
         $servicemajor = Db::name('classify')
        ->field('a.id,a.pname,b.cid,b.name')
        ->alias('a')
        ->join('classify_data b','a.id = b.pid')
        ->where('a.id',3)
        ->where('b.delete_time','null')
        ->select();
        //顾问学位
        $guwen=Db::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',4)
            ->where('b.delete_time','null')
            ->select();
        //申请学位
        $shenqing=Db::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',6)
            ->where('b.delete_time','null')
            ->select();
        $this->assign([
                  'info'         =>$info,
                  'serviceschool'  => $serviceschool,
                  'servicearea'  => $servicearea,
                  'servicemajor' => $servicemajor,
                  'guwen' => $guwen,
                  'shenqing' => $shenqing,
              ]);
        return $this->fetch('add');

  }



    public function del()
    {
        $id     = $this->id;
        $result = Teachers::destroy(function ($query) use ($id) {
            $query->whereIn('id', $id);
        });
        if ($result) {
            return $this->deleteSuccess();
        }
        return $this->error('删除失败');
    }


}