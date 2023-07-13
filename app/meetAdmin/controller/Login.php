<?php

namespace app\meetAdmin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;
use think\facade\Request;
use think\facade\Session;

class Login extends BaseController
{
    public function login()
    {  
        if(Session::has('admin_id')==true){
            return  redirect('/meetAdmin/index/index');
        }
        return View::fetch();
    }
    public function dologin()
    {  
        $data = Request::post();

        $user = Db::name('manager')->where('username', $data['username'])->find();
        if(!$user){
            return json(['code' => 1, 'info' => '无此账户！']);
        }
        if($user['password']!=$data['password']){
            return json(['code' => 1, 'info' => '密码错误！']);
        }

        Session::set('admin_id', $user['id']);
        return json(['code' => 0, 'info' => '登录成功']); 
        
    }
}
