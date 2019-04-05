<?php
/**
 * Created by PhpStorm.
 * User: xiaob
 * Date: 2018/11/15
 * Time: 19:03
 */

namespace app\admin\controller;
use think\Controller;

class Liuyan extends Controller
{

    public function index(){
        $where = input('post.');
        if($where){
            $start = $where['start']?$where['start']:"2017-11-22";
            $end = $where['end']?$where['end']:"2019-11-22";
            $time['times'] = array('between', array($start,$end));
                if($where['text']){
                    $text = $where['text']?$where['text']:"";
                    $data['title'] = array('like', "%$text%");
                }else{
                    $data = "1=1";
                }
            $info = db('leave')
                ->where($data)
                ->where($time)
                ->field('*')->paginate(5);
        }else{
                $info=db('leave')->field('*')->paginate(5);
        }
        $this->assign('info',$info);
        $count = db('leave')->count();   //条数
        $this->assign('count', $count);          //条数映射
        $page = $info->render();                        //分页
        $this->assign('page', $page);            //分页映射
        return $this->fetch();
    }
//    删除
    public function  del(){
        $id = input('id');
        $info = db('leave')->delete($id);
        if($info){
            return $msg = ['code'=>'1'];
        }
    }
}