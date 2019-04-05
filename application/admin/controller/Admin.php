<?php
/**
 * Created by PhpStorm.
 * User: xiaob
 * Date: 2018/11/15
 * Time: 16:08
 */
namespace app\admin\controller;
use think\Controller;
use think\Cookie;
use think\Session;
//    类分割线
class Admin extends Controller
{
    public function login(){
        return $this->fetch('login');
    }
//登陆
    public  function dl(){
            $input = input('post.');
            $where['pass'] = $input['pass'];
            $where['user'] = $input['user'];
//          检测验证码是否正确 不正确返回2
            if (!captcha_check($input['captcha'])){
                return($msg = ['code'=>'2']);
            }else{
//              判断账户密码是否正确
                $info = db('admin')->where($where)->find();
                if($info){
//                    判断是否选中 是就写入cookie
                    if(isset($input['dl'])){
                        Cookie::set('user',$input['user'],36000);
                    }
                    session('user',$input['user']);
                    return $msg = ['code'=>'1'];
                }else{
                    return $msg = ['code'=>'0'];
                }
            }
    }



//    退出登陆
    public  function tuichu(){
         Session::delete('user');
        Cookie::delete('user');
        $this->success('退出成功',url('login'));
    }
//    类分割线
}