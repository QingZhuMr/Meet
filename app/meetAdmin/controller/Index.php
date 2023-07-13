<?php

namespace app\meetAdmin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;
use think\facade\Request;
use think\facade\Session;

class Index extends BaseController
{
    public function index()
    {
        if (Session::has('admin_id') != true) {
            return  redirect('/meetAdmin/login/login');
        }
        
        $admin_id=Session::get('admin_id');
        $admin=Db::name('manager')->where('id',$admin_id)->find();

        View::assign('admin', $admin);

        
        return View::fetch();
    }
    public function doquit(){
        $data = Request::post();
        $data['id'] = Session::get('admin_id');
        Session::delete('admin_id',$data['id']);
        
        return json(['code' => 0, 'info' => '退出成功']);

    }
    public function welcome()
    {
        
        return View::fetch();
    }
    public function menu()
    {
        
        return View::fetch();
    }
    public function setting()
    {
        
        return View::fetch();
    }
}
