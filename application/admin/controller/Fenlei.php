<?php
/**
 * Created by PhpStorm.
 * User: xiaob
 * Date: 2018/11/15
 * Time: 19:02
 */

namespace app\admin\controller;
use think\Controller;

class fenlei extends Controller
{
    public function index(){
//      正常主页映射
        $info = db('soft_article_cat')->where('parent_id=0')->select();
        foreach($info as $key=>&$val){
            $val['二级']=db('soft_article_cat')->where('parent_id='.$val['cat_id'])->select();
            foreach($val['二级'] as $k=>&$v){
                $v['三级']=db('soft_article_cat')->where('parent_id='.$v['cat_id'])->select();
            }
        }
//        echo "<pre>";
//        print_r($info);

        $this->assign('info',$info);
//      条数映射
        $count = db('soft_article_cat')->count();   //条数
        $this->assign('count',$count);              //条数映射
        return $this->fetch();
    }

//    添加
    public function add(){
        $where = input('post.');
        if ($where){
            $res = db('soft_article_cat')->insert($where);
            if($res){
                return "添加成功";
            }
        }else{
            $info=db('soft_article_cat')->where('parent_id=0')->select();
            foreach($info as $key=>&$v)
            {
                $v['list']=db('soft_article_cat')->where('parent_id='.$v['cat_id'])->select();
            }
            $this->assign('lis',$info);

//            二级id
            $id = input('id');
            $this->assign('id',$id);

//            三级id
            $pid = db('soft_article_cat')->where('parent_id='.$id)->find();
            $this->assign('pid',$pid);

        }
        return $this->fetch('add');
    }

//    添加大栏目
    public function adds(){
        $where = input('post.');
        $info = db('soft_article_cat')->insert($where);
           if ($info){
               return "1";
           }else{
               return "0";
           }
    }

//    修改
    public function upd(){
        $where = input('post.');
        if ($where){
            $res = db('soft_article_cat')->update($where);
            if($res){
                return "修改成功";
            }
        }else{
            $info=db('soft_article_cat')->where('parent_id=0')->select();
            foreach($info as $key=>&$v)
            {
                $v['list']=db('soft_article_cat')->where('parent_id='.$v['cat_id'])->select();
            }
            $this->assign('lis',$info);

//            二级id
            $id = input('id');
            $info = db('soft_article_cat')->where('cat_id='.$id)->find();
            $this->assign('id',$id);
            $this->assign('name',$info);

//            三级id
            $pid = db('soft_article_cat')->where('parent_id='.$id)->find();
            $this->assign('pid',$pid);

        }
        return $this->fetch();
    }

//    删除
    public function del(){
        $where = input('post.');
        $info = db('soft_article_cat')->delete($where);
        if($info){
            return json($msg = ['code'=>'删除成功']);
        }
    }
}