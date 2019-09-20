<?php

namespace app\index\controller;

use think\Db;
use app\common\model\Cases;
use app\common\model\Evaluates1;

class Cas extends Controller
{
    public function index(){

        if(isset($_GET['id']) && !empty($_GET['id'])){
            $cid=$_GET['id'];

            $model=new Cases();
            $cases=$model
                ->whereOr('major_chief',$cid)      //专业大类
                ->whereOr('school1',$cid)          //录取院校
                ->whereOr('region',$cid)           //地区
                ->order('id asc')
                ->paginate(12);
        }else{
            $model=new Cases();
            $cases=$model
                ->order('id asc')
                ->paginate(12);
        }

        //专业大类
        $majors=DB::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',3)
            ->where('b.delete_time','null')
            ->select();

        //录取院校前五个
        $school1s=DB::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',5)
            ->where('b.delete_time','null')
            ->limit(5)
            ->select();

        //录取院校第六个到最后（折叠栏下的）
        $school2s=DB::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',5)
            ->where('b.delete_time','null')
            ->limit(5,200)
            ->select();

        //地区
        $areas=DB::name('classify')
            ->alias('a')
            ->join('classify_data b','a.id = b.pid')
            ->field('b.cid,b.name')
            ->where('a.id',2)
            ->where('b.delete_time','null')
            ->select();




        //学生评价
        $evaluates=Evaluates1::order('id asc')->select();


        return view('index',[
            'cases'     =>  $cases,
            'evaluates' =>  $evaluates,
            'majors'    =>  $majors,       //专业大类
            'school1s'   =>  $school1s,    //录取院校第一排前五
            'school2s'   =>  $school2s,    //录取院校剩下
            'areas'      =>  $areas,       //地区

        ]);
    }
}
