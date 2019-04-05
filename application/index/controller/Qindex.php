<?php
/**
 * Created by PhpStorm.
 * User: xiaob
 * Date: 2018/11/15
 * Time: 19:49
 */
namespace app\index\controller;
use think\Controller;

class Qindex extends controller
{

    //主页
    public function index(){
//      检测ip--浏览
        $ip = $_SERVER['REMOTE_ADDR'];
        $info = db('liulan')->where('ip',$ip)->find();
        if(!$info){
            $data = ['ip'=>$ip];
            db('liulan')->insert($data);
        }

//      收藏
        $shoucang = input('flg');
        if($shoucang){
            $info2 = db('shoucang')->where('ip',$ip)->find();
            if($info2){
                return $msg = ['code'=>'1'];
            }else{
                $data = ['ip'=>$ip];
                db('shoucang')->insert($data);
            }
        }
//Banner
        $banner1 = db('soft_article_cat')->where('cat_name="Banner"')->select();
        $banner2 = db('product')->where('cat_id='.$banner1['0']['cat_id'])->select();
        $this->assign('banner',$banner2);

//荣誉资质
        $chanping1 = db('soft_article_cat')->where('cat_name="荣誉资质"')->select();
        $chanping2 = db('product')->where('cat_id='.$chanping1['0']['cat_id'])->select();
        $this->assign('chanping',$chanping2);

//产品资质
        $zizhi1 = db('soft_article_cat')->where('cat_name="产品中心"')->select();
        $zizhi2 = db('product')->where('cat_id='.$zizhi1['0']['cat_id'])->select();
        $this->assign('zizhi',$zizhi2);

//主页多选
        $index1 = db('soft_article_cat')->where('cat_name="新闻资讯"')->select();
        $index2 = db('soft_article_cat')->where('parent_id='.$index1['0']['cat_id'])->select();
        $this->assign('index',$index2);
//多选内容
// 理论是可以的但那边传不过来id所以写了一个死id
        $id = input('id');
        $con = db('soft_article')->where('cat_id=14')->select();
        $this->assign('con',$con);

//搜索
//        $sel = input('post.');
//        if($sel){
//            return $sel;
//        }

//主页显示
        $qiyejieshao =   $index1 = db('soft_article')->where('title="企业介绍"')->find();
        $this->assign('qiyejieshao',$qiyejieshao);

        return $this->fetch('index');
    }

//联系我们
    public function contact(){
        $info = db('soft_article_cat')->where('cat_name="联系我们"')->find();//得到自己id
        $info2 = db('soft_article_cat')->where('parent_id='.$info['cat_id'])->select();//通过查上面得到的父亲id得到自己的id
        $con = db('soft_article')->where('cat_id='.$info2['0']['cat_id'])->select();//通过上面得到自己的id对应查到新闻
        $this->assign('con',$con);
        return $this->fetch('contact');
    }


//新闻资讯
    public function new_list(){
        $info = db('soft_article_cat')->where('cat_name="新闻资讯"')->find();
        $info2 = db('soft_article_cat')->where('parent_id='.$info['cat_id'])->select();
        $id = input('id')?input('id'):$info2['0']['cat_id'];//下标为0也就是第一个等于关于我们的会被选中
        $this->assign('list',$info2);
        $this->assign('id',$id);

//        内容
        $con = db('soft_article')->where('cat_id='.$id)->paginate(5);
        $this->assign('con',$con);
        $this->assign('page',$con->render());
        return $this->fetch();
    }

//新闻详情页
    public function new_info(){
        $info = db('soft_article_cat')->where('cat_name="新闻资讯"')->find();
        $info2 = db('soft_article_cat')->where('parent_id='.$info['cat_id'])->select();
        $id = input('id')?input('id'):$info2['0']['cat_id'];//下标为0也就是第一个等于关于我们的会被选中
        $this->assign('list',$info2);
        $this->assign('id',$id);

        $con_id = input('con');
        $con = db('soft_article')->where('article_id='.$con_id)->find();
        $this->assign('con',$con);
//        $prev=db('soft_article')
//            ->where('article_id<'.$content)
//            ->order('article_id desc')
//            ->field('article_id,cat_id')
//            ->find();
//        $this->assign('prev',$prev);
//
//        $next=db('soft_article')
//            ->where('article_id>'.$content)
//            ->order('article_id asc')
//            ->field('article_id,cat_id')
//            ->find();
//
//        $this->assign('next',$next);
//        <div class="com-info-page">
//           <a href="{:url('new_info',['type_id'=>$prev.article_id,'cat_id'=>$prev.cat_id])}" class="no">上一篇</a>
//           <a href="{:url('new_info',['type_id'=>$next.article_id,'cat_id'=>$next.cat_id])}">下一篇</a>
//         </div>

        return $this->fetch();
    }

//产品展示
    public function product_list(){
        $info = db('soft_article_cat')->where('cat_name="产品展示"')->find();
        $info2 = db('soft_article_cat')->where('parent_id='.$info['cat_id'])->select();
        $id = input('id')?input('id'):$info2['0']['cat_id'];//下标为0也就是第一个等于关于我们的会被选中
        $this->assign('list',$info2);
        $this->assign('id',$id);

//        内容
        $con = db('product')->where('cat_id='.$id)->paginate(6);
        $this->assign('con',$con);
        $this->assign('page',$con->render());
//        echo "<pre>";
//        print_r($con);

        return $this->fetch();
    }
//关于我们
    public function about(){
        $info = db('soft_article_cat')->where('cat_name="关于我们"')->find();
        $info2 = db('soft_article_cat')->where('parent_id='.$info['cat_id'])->select();
        $id = input('id')?input('id'):$info2['0']['cat_id'];//下标为0也就是第一个等于关于我们的会被选中
        $this->assign('list',$info2);
        $this->assign('id',$id);

//        内容
        $con = db('soft_article')->where('cat_id='.$id)->select();
        $this->assign('con',$con);

//       当前位置
        $xiabiao = db('soft_article_cat')->where('cat_id='.$id)->find();
        $this->assign('xiabiao',$xiabiao);

        return $this->fetch();
    }


//加入我们
    public function goin(){
        return $this->fetch();
    }

//在线留言
    public function message(){
        $info = input('post.');
        if($info){
            $info['times'] = date('Y-m-d');
            $info['ip'] = $_SERVER["REMOTE_ADDR"];
            $db = db('leave')->insert($info);
            return "1";
        }else{
            return $this->fetch('message');
        }
    }

//产品详情页
    public function product_info(){
        $info = db('soft_article_cat')->where('cat_name="产品展示"')->find();
        $info2 = db('soft_article_cat')->where('parent_id='.$info['cat_id'])->select();
        $id = input('id')?input('id'):$info2['0']['cat_id'];//下标为0也就是第一个等于关于我们的会被选中
        $this->assign('list',$info2);
        $this->assign('id',$id);

//内容
        $con = db('product')->where('id='.$id)->find();
        $this->assign('con',$con);

        return $this->fetch();
    }

}