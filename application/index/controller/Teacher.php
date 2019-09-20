<?php
/**
 * 导师展示前台
 *
 */

namespace app\index\controller;
use think\Db;
use app\common\model\Teachers;
use app\common\model\Newss as Consultation;
use app\common\model\Evaluates;


class Teacher extends Controller
{
    public function index()
    {
        if (isset($_GET['content']) && !empty($_GET['content'])){
            $content=$_GET['content'];
            //专业
            $cids=DB::name('classify_data')
                ->field('cid')
                ->where('name',$content)
                ->find();
            $cid=$cids['cid'];

            $model=new Teachers();
            $teachars=$model
                ->whereOr('serviceschool',$cid)
                ->whereOr('counselor',$cid)
                ->whereOr('servicemajor',$cid)
                ->order('id asc')
                ->paginate(2);
        }elseif (isset($_GET['id']) && !empty($_GET['id'])){

            $cid=$_GET['id'];

            $model=new Teachers();
            $teachars=$model
                ->whereOr('serviceschool',$cid)    //学校
                ->whereOr('counselor',$cid)        //顾问学位（学历）
                ->whereOr('servicemajor',$cid)     //专业
                ->whereOr('servicearea',$cid)      //地区
                ->whereOr('apply',$cid)             //申请学位
                ->order('id asc')
                ->paginate(2);
        }else{
            $model=new Teachers();
            $teachars=$model
                ->order('id asc')
                ->paginate(2);
        }


        //留学地区
        $areas=DB::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',2)
            ->where('b.delete_time','null')
            ->select();

        //专业
        $majors=DB::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',3)
            ->where('b.delete_time','null')
            ->select();

        //顾问学位
        $guwen=DB::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',4)
            ->where('b.delete_time','null')
            ->select();

        //申请学位
        $shenqing=DB::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',6)
            ->where('b.delete_time','null')
            ->select();

        //资讯
        $news = new Consultation();
        $news = $news
            ->order('id desc')
            ->limit(6)
            ->select();


        return view('index',[
            'teachers'   =>  $teachars,
            'areas'      =>  $areas,
            'majors'     =>  $majors,
            'guwens'    =>  $guwen,
            'shenqings'=>  $shenqing,
            'news'       =>  $news,
        ]);
    }


    public function detail($id)
    {
      $teacher = Teachers::find($id);

      $educations = Db::name('teacher')
          ->alias('a')
          ->join('education b','a.id = b.t_id')
          ->field('b.school,b.major,b.time,b.logo')
          ->where('a.id',$id)
          ->where('b.delete_time','null')
          ->select();

        //资讯
        $news = new Consultation();
        $news = $news
            ->order('id desc')
            ->limit(6)
            ->select();

        //评价
        $evaluates=new Evaluates();
        $evaluates=$evaluates
            ->where('teacher_id',$id)
            ->order('id desc')
            ->limit(4)
            ->select();

      return view('detail',[
          'id'           =>$id,
          'teacher'      =>  $teacher,
          'educations'   =>  $educations,
          'news'          =>  $news,
          'evaluates'     =>  $evaluates,
      ]);
    }

    public function add($id){
        $message=$this->request->param('message');
        $major=$this->request->param('major');
        $service=$this->request->param('service');
        $comment=$this->request->param('comment');

        $evaluate=new Evaluates();
        $evaluate->user_id=1;
        $evaluate->teacher_id=$id;
        $evaluate->message=$message;
        $evaluate->major=$major;
        $evaluate->service=$service;
        $evaluate->comment=$comment;

        if($evaluate->save()){
            return $id;
        }


    }



}