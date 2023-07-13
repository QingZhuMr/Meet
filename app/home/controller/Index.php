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
        if($user['year']==null){
            $user['age'] = 0;
        }

        View::assign('user', $user);
        View::assign('url', $url);
        return View::fetch();
    } 
}
