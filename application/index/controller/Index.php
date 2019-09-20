<?php
/**
 * 网站首页
 *
 */

namespace app\index\controller;


use app\admin\controller\Experience;
use app\common\model\BottomImages;
use app\common\model\TopImages;
use app\common\model\Cases;
use app\common\model\Newss;
use app\common\model\Experiences;

class Index extends Controller
{
    public function index()
    {
        $model = new TopImages();
        $list = $model
            ->order('id','asc')
            ->limit(1)
            ->select();

        $list1 = $model
            ->order('id','asc')
            ->limit(1,10)
            ->select();


        $model=new Cases();
        $cases=$model
            ->order('id asc')
            ->select();

        $news=new Newss();
        $newsa=$news
            ->order('id asc')
            ->limit(3)
            ->select();


        $newsb=$news
            ->order('id asc')
            ->limit(3,10)
            ->select();


        $model = new BottomImages();
        $bottomimages = $model
            ->order('id','asc')
            ->select();

        $experience=new Experiences();
        $experiences=$experience
            ->order('id','asc')
            ->select();


        $this->assign([
            'list'      => $list,
            'list1'      => $list1,
            'cases'      => $cases,
            'newsa'      => $newsa,
            'newsb'      => $newsb,
            'bottomimages'      => $bottomimages,
            'experiences'      => $experiences,
        ]);

        return $this->fetch();
    }

    
}