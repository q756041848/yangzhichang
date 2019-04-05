<?php
/**
 * Created by PhpStorm.
 * User: xiaob
 * Date: 2018/11/15
 * Time: 16:49
 */

namespace app\admin\controller;
use think\Controller;

class Index extends Base
{
//    index页映射
    public function index(){
        return $this->fetch('index');
    }

//    index内容页映射
    public function content(){
        $info = array(
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式'=>php_sapi_name(),
            'ThinkPHP版本'=>THINK_VERSION.' [ <a href="http://thinkphp.cn" target="_blank">查看最新版本</a> ]',
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '剩余空间'=>round((disk_free_space(".")/(1024*1024)),2).'M',
            'register_globals'=>get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
            'magic_quotes_gpc'=>(1===get_magic_quotes_gpc())?'YES':'NO',
            'magic_quotes_runtime'=>(1===get_magic_quotes_runtime())?'YES':'NO',
        );
//        浏览数
        $liulan = db('liulan')->count();
        $this->assign('liulan',$liulan);
//        文章数
        $wenzhang = db('soft_article')->count();
        $this->assign('wenzhang',$wenzhang);
//        产品数
        $product = db('product')->count();
        $this->assign('product',$product);
//        栏目数
        $lanmu = db('soft_article_cat')->count();
        $this->assign('lanmu',$lanmu);
//        收藏数
        $shoucang = db('shoucang')->count();
        $this->assign('shoucang',$shoucang);
//        留言页数
        $shoucang = db('leave')->count();
        $this->assign('admin',$shoucang);

        $this->assign('info',$info);
        return $this->fetch();
    }
}