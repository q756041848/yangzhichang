<?php
/**
 * Created by PhpStorm.
 * User: xiaob
 * Date: 2018/11/15
 * Time: 19:03
 */

namespace app\admin\controller;

use think\Controller;

class Font extends Controller
{
    public function font(){
        return $this->fetch();
    }
}