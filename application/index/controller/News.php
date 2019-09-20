<?php
/**
 * 留学资讯前台
 */

namespace app\index\controller;
use think\Db;
use think\Request;
use app\common\model\Newss;


class News extends Controller
{
    public function index()
    {
        //判断，带id过来的条件查询，不带的全部查询
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $cid=$_GET['id'];

            $news=new Newss();
            $list=$news
                ->where('c_id',$cid)
                ->order('id asc')
                ->limit(6)
                ->select();
        }else{
            $news = new Newss();
            $list = $news
                ->order('id asc')
                ->limit(6)
                ->select();
        }

      //从数据库关联查询出文章类别
        $categorys=DB::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',1)
            ->where('b.delete_time','null')
            ->select();

      $this->assign([
          'list'       => $list,
          'categorys'  => $categorys,    //将文章类别分配到视图，在视图遍历出来即可
      ]);

      return $this->fetch();
    }


    public function detail()
    {
        $news = new Newss();
        $list = $news
            ->order('id asc')
            ->limit(6)
            ->select();


      $id =Request::instance()->get('id');

      $info = Db::name('news')
      ->where('id',$id)
      ->find();

      //上一篇id
      $id_before=$id-1;
      //上一篇资讯
      if($id_before>0){
          $info_before=Db::name('news')
              ->where('id',$id_before)
              ->find();
      }

      if($id_before>0){
          $info_before=$info_before;
      }else{
          $info_before=['title' => '无'];
      }


        //下一篇id
        $id_after=$id+1;
        //下一篇资讯
        if($id_after<=count($list)){
            $info_after=Db::name('news')
                ->where('id',$id_after)
                ->find();
        }

        if($id_after<=count($list)){
            $info_after=$info_after;
        }else{
            $info_after=['title' => '无'];
        }

      $news = new Newss();
      $list = $news
          ->order('id asc')
          ->limit(6)
          ->select();
      $this->assign([
         'info'      => $info,
          'list'     => $list,
          'info_before'  =>  $info_before,
          'info_after'  =>  $info_after
     ]);
       return $this->fetch();
    }

}