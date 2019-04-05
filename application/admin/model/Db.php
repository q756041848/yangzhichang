<?php
namespace app\admin\model;
use think\Model;

class Db extends Model
{
    public function getrolelist()
    {
        $info=db('soft_article_cat')->where('parent_id=0')->select();
        foreach($info as $key=>&$v)
        {
            $v['list']=db('soft_article_cat')->where('parent_id='.$v['cat_id'])->select();
        }
        return $info;
    }
}
