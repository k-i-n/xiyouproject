<?php
/**
 * 后台数据分类管理
 * @author yupoxiong<i@yufuping.com>
 */

namespace app\admin\controller;
use think\Request;
use app\common\model\Attachments;
use app\admin\model\Classifys;
use app\admin\model\ClassifyDatas;

class Classify extends Base
{

    public function index()
    {
        $model = new Classifys();
        $page_param = ['query' => []];
        if (isset($this->param['keywords']) && !empty($this->param['keywords'])) {
            $page_param['query']['keywords'] = $this->param['keywords'];

            $model->whereLike('pname', "%" . $this->param['keywords'] . "%");
            $this->assign('keywords', $this->param['keywords']);
        }

        $list = $model
            ->order('id asc')
            ->paginate($this->webData['list_rows'], false, $page_param);
        $this->assign([
            'list' => $list,
            'page'  => $list->render(),
            'total' => $list->total()
        ]);
        return $this->fetch();
    }



    public function add()
    {
        if ($this->request->isPost()) {
            $resultValidate = $this->validate($this->param, 'Classifys.classify');
            if (true !== $resultValidate) {
                return $this->error($resultValidate);
            }
            $result = Classifys::create($this->param);
            if ($result) {
                return $this->success();
            }
            return $this->error();
        }

        return $this->fetch();
    }


    public function edit()
    {
        $info = Classifys::get($this->id);
        if ($this->request->isPost()) {
            $resultValidate = $this->validate($this->param, 'Classifys.classify');
            if (true !== $resultValidate) {
                return $this->error($resultValidate);
            }

            if (false !== $info->save($this->param)) {
                return $this->success();
            }
            return $this->error();
        }

        $this->assign([
            'info'       => $info,
        ]);
        return $this->fetch('add');
    }


    public function del()
    {

        $id     = $this->id;
        $result = Classifys::destroy(function ($query) use ($id) {
            $query->whereIn('id', $id);
        });
        if ($result) {
            return $this->deleteSuccess();
        }
        return $this->error('删除失败');
    }

    /**
     * 对子表进行操作
     */
    public function view(){

      $id =$this->id;
      $model = new ClassifyDatas();
      $pageParam['query']['id'] = $id;
      $list = $model
          ->where('pid',$id)
          ->paginate($this->webData['list_rows'], false, $pageParam);

        $this->assign([
          'list'  => $list,
          'total' => $list->total(),
          'page'  => $list->render(),
          'id'    => $id,
      ]);

      return $this->fetch();

    }

    public function addlot(){
      $pid = request()->get('pid');
      if ($this->request->isPost()) {
        $resultValidate = $this->validate($this->param, 'ClassifyDatas.classifyData');
        if (true !== $resultValidate) {
            return $this->error($resultValidate);
        }
        $this->param['pid'] = $pid;
        $result = ClassifyDatas::create($this->param);
        if ($result) {
            return $this->success();
        }
            return $this->error();
        }

            return $this->fetch('');
    }

    public function editlot()
    {
        $info = ClassifyDatas::get($this->id);
        if ($this->request->isPost()) {
            $resultValidate = $this->validate($this->param, 'ClassifyDatas.classifyDatas');
            if (true !== $resultValidate) {
                return $this->error($resultValidate);
            }

            if (false !== $info->save($this->param)) {
                return $this->success();
            }
            return $this->error();
        }

        $this->assign([
            'info'       => $info,
        ]);
        return $this->fetch('addlot');
    }

      public function del2()
      {

          $id     = $this->id;
          $result = ClassifyDatas::destroy(function ($query) use ($id) {
              $query->whereIn('id', $id);
          });
          if ($result) {
              return $this->deleteSuccess();
          }
          return $this->error('删除失败');
      }





}