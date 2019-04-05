<?php
/**
 * Created by PhpStorm.
 * User: xiaob
 * Date: 2018/11/20
 * Time: 11:21
 */

namespace app\admin\controller;
use think\Controller;

class Adminlist extends Controller
{
/////////////////  【管理员页   think_role】   ///////////////////
  public function admin()
  {
      $data = db('admin')->paginate(5);
      $this->assign('list',$data);
      $this->assign('page',$data->render());      //分页映射
      return $this->fetch('admin');
  }

  public function admindel(){
      $id = input('id');
      $str = db('admin')->delete($id);
      if($str){
          return "1";
      }
}

  //添加修改要等角色完成后再做
  public function adminupd(){
      $id = input('id');
      $data = input('post.');
      if($data){
          $where['role_id'] = $data['role_id'];   //给另一个表
          unset($data['role_id']);                //删除
          $admin = db('admin')->where('id='.$id)->update($data);
          $think_role_user = db('think_role_user')->where('user_id='.$id)->update($where);
          return $think_role_user;
      }else{
//          下拉数据
          $info=db('think_role')->where('pid=0')->select();
          foreach($info as $key=>&$v)
          {
              $v['list']=db('think_role')->where('pid='.$v['id'])->select();
          }
          $this->assign('list',$info);
//页面数据

          return $this->fetch('admin-upd');
      }
  }
//添加
  public function adminadd(){
    $data = input('post.');
    if($data){
        $data['time'] = date('Y-m-d');  //创建时间默认
        $data['status'] = 1;                    //状态值默认
        $where['role_id'] = $data['role_id'];   //给另一个表
        unset($data['role_id']);                //删除
        $id = db('admin')->insertGetId($data);  //插入并得到刚才的id
        $where['user_id'] = $id;                //给我另一个表
        $status = db('think_role_user')->insert($where);
        return $status;
    }else{
//          下拉数据
        $info=db('think_role')->where('pid=0')->select();
        foreach($info as $key=>&$v)
        {
            $v['list']=db('think_role')->where('pid='.$v['id'])->select();
        }
        $this->assign('list',$info);
//          页面数据
        

        return $this->fetch('admin-add');
    }
  }

//  状态
    public function adminstatus(){
        $data = input('get.');
        $info = db('admin')->update($data);
        return $info;
    }


/////////////////  【角色管理页   think_role】   ///////////////////
    public function role()
    {
        $info = db('think_role')->where('pid=0')->select();
        foreach($info as $key=>&$val){
            $val['二级']=db('think_role')->where('pid='.$val['id'])->select();
            foreach($val['二级'] as $k=>&$v){
                $v['三级']=db('think_role')->where('pid='.$v['id'])->select();
            }
        }

        $this->assign('info',$info);
        return $this->fetch('role');
    }


//  角色状态
    public function rolestatus(){
        $data = input('get.');
        $info = db('think_role')->update($data);
        return $info;
    }


//  角色修改页
    public function roleupd()
    {
        $id = input('id');
        $this->assign('id',$id);

        $con = db('think_role')->where('id='.$id)->select();
        $this->assign('info',$con);

        $where = input('post.');
        if ($where){
            $where['status'] = 1;
            $res = db('think_role')->update($where);
                if($res){
                    return "修改成功";
                }
        }else{
            $info=db('think_role')->where('pid=0')->select();
            $this->assign('lis',$info);
        }
        return $this->fetch('role-upd');
    }


//  角色添加页
    public function roleadd()
    {
//      自id
        $id = input('id');
        $this->assign('id',$id);

        $where = input('post.');
        if ($where){
            $where['status'] = 1;
            $res = db('think_role')->insert($where);
            if($res){
                return "添加成功";
            }
        }else{
            $info=db('think_role')->where('pid=0')->select();
            $this->assign('lis',$info);
        }

        return $this->fetch('role-add');
//              {foreach name="$val.list" id="szhi"}
//              <option  value="{$szhi.id}">&nbsp;&nbsp;&nbsp;&nbsp;--{$szhi.name}</option>
//              {/foreach}
//             foreach($info as $key=>&$v)
//             {
//             $v['list']=db('think_role')->where('pid='.$v['id'])->select();
//             }
    }

//  角色删除页
    public function roledel()
    {
        $id = input('id');
        $str = db('think_role')->delete($id);
        if($str){
            return "1";
        }
    }


//   顶级栏目添加
    public function adds(){
        $where = input('post.');
        $info = db('think_role')->insert($where);
        if ($info){
            return "1";
        }else{
            return "0";
        }
    }

/////////////////  【角色管理页   think_role】   ///////////////////
/////////////////  【角色管理页   think_role】   ///////////////////


}