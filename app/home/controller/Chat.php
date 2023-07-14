<?php
namespace app\home\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;
use think\facade\Request;

class Chat extends BaseController
{
    public function chat()
    {
        
        $url = Request::domain();
        //$index=Db::name('system')->where('id', 1)->find();
       // var_dump($index);
        //TP6模板输出
        // View::assign('index', $index);
        View::assign('url', $url);
        return View::fetch();
    }
 
}
