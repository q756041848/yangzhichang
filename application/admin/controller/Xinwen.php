<?php
/**
 * Created by PhpStorm.
 * User: xiaob
 * Date: 2018/11/15
 * Time: 18:59
 */

namespace app\admin\controller;
use think\Controller;
use think\File;
use think\Request;
use think\response\Json;

class xinwen extends Controller
{
    public function index()
    {
            $where = input('post.');
            if($where){
                $start = $where['start']?$where['start']:"2017-11-22";
                $end = $where['end']?$where['end']:"2019-11-22";
                $time['add_time'] = array('between', array($start,$end));
                    if($where['text']){
                        $text = $where['text']?$where['text']:"";
                        $data['title'] = array('like', "%$text%");
                    }else{
                        $data = "1=1";
                    }
                $info = db('soft_article')->alias('a')
                  ->where($data)
                  ->where($time)
                  ->join('__SOFT_ARTICLE_CAT__ ac', 'a.cat_id=ac.cat_id')
                 ->field('a.*,ac.cat_name')->paginate(5);

            }else{
                $info = db('soft_article')->alias('a')->join('__SOFT_ARTICLE_CAT__ ac', 'a.cat_id=ac.cat_id')->field('a.*,ac.cat_name')->paginate(5);
//                $con = htmlspecialchars($info['0']['content']);//html标签无效化
//                $con = substr($con, 0, 100);  //截取0-100位的内容
//                $this->assign('con', $con.'...');
            }
            $this->assign('list', $info);
            $page = $info->render();                        //分页
            $this->assign('page', $page);            //分页映射

            $count = db('soft_article')->count();   //条数
            $this->assign('count', $count);          //条数映射
            return $this->fetch('index');
    }


//    富文本本地上传
    public  function imgs(){
        if ($_FILES){
            $string = date("Y-m-d");
            $string = preg_replace('/[-]+/i','',$string);
            $file = request()->file('images');
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            //富文本返回值
            $ret = [];
            $data[] =  "http://127.0.0.1/tp/public/uploads/".$string."/".$info->getFilename();
            $ret['errno'] = 0;
            $ret['data'] = $data;
            return json_encode($ret,JSON_UNESCAPED_SLASHES);
        }
    }

    public  function  add()
    {
        $input = input('post.');
        if($input){
            $input['add_time'] = date("Y-m-d");
            $info = db('soft_article')->insert($input);
            return JSON($msg = ["code"=>"1"]);
        }else{
            $this->assign('lis',model('Db')->getrolelist());
            return $this->fetch('add');
        }
    }

    public  function  upd(){
        $input = input('post.');
        if($input){
            $input['add_time'] = date("Y-m-d");
            $info = db('soft_article')->update($input);
            return JSON($msg = ["code"=>"1"]);
        }else{
            $id = input('id');
            $info=db('soft_article')->where('article_id='.$id)->find();
            $this->assign('lis',model('Db')->getrolelist());
            $this->assign('info',$info);
        }
        return $this->fetch();
    }

    public  function del(){
        $id = input('ids');
        $info = db('soft_article')->delete($id);
        if($info){
            return $msg = ['code'=>'1'];
        }
    }
}