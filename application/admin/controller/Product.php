<?php
/**
 * 用户管理
 * @author yupoxiong<i@yufuping.com>
 */

namespace app\admin\controller;

use app\common\model\Attachments;
use app\common\model\Product as Productmodel;

class Product extends Base
{
    public function index()
    {
        $model = new Productmodel();
        
          $pageParam = ['query' => []];
        if (isset($this->param['keywords']) && !empty($this->param['keywords'])) {
            $pageParam['query']['keywords'] = $this->param['keywords'];
            $model->whereLike('name|nickname|email|mobile', "%" . $this->param['keywords'] . "%");
            $this->assign('keywords', $this->param['keywords']);
        }
        $list = $model->paginate($this->webData['list_rows'], false, $pageParam);
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
            $file                    = $attachment->upload('proimage');
            if ($file) {
                $this->param['proimage'] = $file->url;
            }else{
                return $this->error($attachment->getError());
            }
            $this->param['content'] =  stripslashes($_POST['content']);
            $result = Productmodel::create($this->param);
            if ($result) {
                return $this->success();
            }
            return $this->error();
        }
       
        return $this->fetch();
    }

 public function edit()
    {
        $info = Productmodel::get($this->id);
        if ($this->request->isPost()) {
            $resultValidate = $this->validate($this->param, 'Product.edit');
            if (true !== $resultValidate) {
                return $this->error($resultValidate);
            }
            if ($this->request->file('proimage')) {
                $attachment = new Attachments();
                $file       = $attachment->upload('proimage');
                if ($file) {
                    $this->param['proimage'] = $file->url;
                } else {
                    return $this->error($attachment->getError());
                }
            }
            $this->param['content'] =  stripslashes($_POST['content']);
            if (false !== $info->save($this->param)) {
                return $this->success();
            }
            return $this->error();
        }
         $this->assign([           
            'info'  => $info
        ]);
        return $this->fetch('add');
    }




    public function del()
    {
        $id     = $this->id;
        $result = Productmodel::destroy(function ($query) use ($id) {
            $query->whereIn('id', $id);
        });
        if ($result) {
            return $this->deleteSuccess();
        }
        return $this->error('删除失败');
    }
    
    
  

}