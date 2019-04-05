<?php
/**
 * Created by PhpStorm.
 * User: xiaob
 * Date: 2018/11/15
 * Time: 20:05
 */
namespace app\admin\controller;
use think\Controller;

class Chanping extends Controller
{
    public function index(){

        $where = input('post.');
        if($where){
            $start = $where['start']?$where['start']:"2017-11-22";
            $end = $where['end']?$where['end']:"2019-11-22";
            $time['addtime'] = array('between', array($start,$end));
            if($where['text']){
                $text = $where['text']?$where['text']:"";
                $data['name'] = array('like', "%$text%");
            }else{
                $data = "1=1";
            }
            $info=db('product')->alias('a')
                ->join('__SOFT_ARTICLE_CAT__ ac','a.cat_id=ac.cat_id')
                ->where($data)
                ->where($time)
                ->field('a.*,ac.cat_name')->paginate(3);
//            $info['content'] = strip_tags($info['content']);
        }else{
            $info=db('product')->alias('a')
                ->join('__SOFT_ARTICLE_CAT__ ac','a.cat_id=ac.cat_id')
                ->field('a.*,ac.cat_name')->paginate(5);
        }

        $this->assign('list',$info);
        $page = $info->render();                        //分页
        $this->assign('page',$page);            //分页映射

        $count = db('product')->count();         //条数
        $this->assign('count',$count);          //条数映射
        return $this->fetch();
    }

    public function add(){
        $input = input('post.');
        if($input){
            $file = request()->file('original_img');
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                $input['original_img']=$info->getSaveName();
            }
            $input['addtime'] = date("Y-m-d");
            $info = db('product')->insert($input);
            return JSON($msg = ["code"=>"1"]);
        }else{
            $this->assign('lis',model('Db')->getrolelist());
            return $this->fetch('add');
        }
        return $this->fetch();
    }

    public function upd(){
        $input = input('post.');
        if($input){
            $file = request()->file('original_img');
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                $input['original_img']=$info->getSaveName();
            }
            $input['addtime'] = date("Y-m-d");
            $info = db('product')->update($input);
            return JSON($msg = ["code"=>"1"]);
        }else{
            $id = input('id');
            $info=db('product')->where('id='.$id)->find();
            $this->assign('lis',model('Db')->getrolelist());
            $this->assign('info',$info);
        }
        return $this->fetch();
    }
    public  function del(){
        $id = input('ids');
        $info = db('product')->delete($id);
        if($info){
            return $msg = ['code'=>'1'];
        }
    }

}