<?php

namespace app\home\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;
use think\facade\Request;
use app\api\validate\UserValidate; //验证
use app\api\model\UserModel; //模型
use think\exception\ValidateException;
use think\facade\Session;


class User extends BaseController
{


    public function login() //登录页面
    {
        if(Session::has('user_id')==true){
            return  redirect('/home/index/index');
        }
        return View::fetch();
    }

    public function register() //注册页面
    {
        if(Session::has('user_id')==true){
            return  redirect('/home/index/index');
        }
        return View::fetch();
    }

    public function dologin() //登录接口
    {
        $data = Request::post();
        //验证
        try {
            validate(UserValidate::class)->check($data);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            return json(['code' => 1, 'info' => $e->getError()]);
        }
        $db = new UserModel();
        $res = $db->getUsersLogin($data);

        if ($res['code'] == 0) {
            Session::set('user_id', $res['id']);
            return json($res);
        } else {
            return json($res);
        }

        // return View::fetch();
    }
    public function doregister() //注册接口
    {
        $data = Request::post();
        //验证
        try {
            validate(UserValidate::class)->check($data);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            return json(['code' => 1, 'info' => $e->getError()]);
        }


        $db = new UserModel();
        $res = $db->addUsers($data);
        if ($res['code'] == 0) {
            Session::set('user_id', $res['id']);
            return json($res);
        } else {
            return json($res);
        }
    }
    public function getUser()
    {
        $data = Request::post();

        $id = $data['id'];
        // dump($id);
        // exit();
        $user = Db::name('user')->where('id', $id)->withoutField('password')->find();
        if (!$user) {
            return  json(['code' => 1, 'info' => '获取信息失败']);
        }
        $user['code'] = 0;
        return json($user);
    }
    public function userinfo(){

        if (Session::has('user_id') != true) {
            return  redirect('/home/user/login');
        }

        $user_id = Session::get('user_id');
        $user = Db::name('user')->where('id', $user_id)->find();

        View::assign('user', $user);
        return View::fetch();
    }
    public function douserinfo(){
        $data = Request::post();

        //验证
        try {
            validate(UserValidate::class)->check($data);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            return json(['code' => 1, 'info' => $e->getError()]);
        }

       $id = $data['id'];
       $data['initialize'] = '1';
       $user = DB::name('user')->where('id',$id)->update($data);
       if($user){
        return json(['code' => 0, 'info' => '保存成功']);
       }else{
        return json(['code' => 1, 'info' => '保存失败']);
       }
        

    }
}
