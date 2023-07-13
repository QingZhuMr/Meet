<?php

namespace app\home\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;
use think\facade\Request;
use think\facade\Session;

class Index extends BaseController
{

    public function index()
    {
        if (Session::has('user_id') != true) {
            return  redirect('/home/user/login');
        }

        $url = Request::domain();
        //$index=Db::name('system')->where('id', 1)->find();
        // var_dump($index);

        // View::assign('index', $index);
        $user_id = Session::get('user_id');
        $user = Db::name('user')->where('id', $user_id)->find();
        $byear = $user['year'];
        $bmonth = $user['month'];
        $bday = $user['day'];

        $tyear = date('Y');
        $tmonth = date('m');
        $tday = date('d');

        $age = $tyear - $byear;
        if ($bmonth > $tmonth || $bmonth == $tmonth && $bday > $tday) {
            $age--;
        }
        $user['age'] = $age;
        // dump($user['age']);
        if ($user['year'] == null) {
            $user['age'] = 0;
        }

        if ($user['lid'] != null) {
            if ($user['sex'] == 1) {
                $sex = 0;
            }
            if ($user['sex'] == 0) {
                $sex = 1;
            }
            $lover = DB::name('user')->where('lid', $user['lid'])->where('sex', $sex)->find();
            $byear = $lover['year'];
            $bmonth = $lover['month'];
            $bday = $lover['day'];

            $tyear = date('Y');
            $tmonth = date('m');
            $tday = date('d');

            $age = $tyear - $byear;
            if ($bmonth > $tmonth || $bmonth == $tmonth && $bday > $tday) {
                $age--;
            }
            $lover['age'] = $age;
            // dump($user['age']);
            if ($lover['year'] == null) {
                $lover['age'] = 0;
            }
            if ($lover['sign'] == null) {
                $lover['sign'] = "暂无个性签名";
            }
            View::assign('lover', $lover);
        }

        View::assign('user', $user);
        View::assign('url', $url);
        return View::fetch();
    }

    public function chat()
    {
        if (Session::has('user_id') != true) {
            return  redirect('/home/user/login');
        }
        $data = Request::get();
        // dump($data);

        return View::fetch();
    }
}
