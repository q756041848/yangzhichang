<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Cookie;
use think\Session;

class Base extends Controller
{
    //    写一个构造函数，每次打开主页都要验证账户密码
    public function __construct(Request $request = null)
    {
        parent::__construct($request);

        //判断有没有coolick 如果有把值给sesson 没有则是sesson正常验证
        if(Cookie::has('user')){
            session('user',Cookie::get('user'));
        }

        if(!session('user')){
            parent::__construct($request);
//			[logo.php内的login映射方法]
            $this->success('尚未登陆',url('admin/login'));
        }
    }
}