<?php

namespace app\meetAdmin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;
use think\facade\Request;
use think\facade\Session;

class Users extends BaseController
{
    public function userslist()
    {
        
        return View::fetch();
    }
    public function getUsers()
    {
        $res = DB::name("user")->select();
//         "msg": "",
//   "count": 1000,
        return json(['code' => 0,'msg'=>'','data'=>$res]);
    }
    public function userspairlist()//情侣列表
    {
        return View::fetch();
    }
}
