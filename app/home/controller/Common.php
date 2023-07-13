<?php
namespace app\home\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;
use think\facade\Request;

class Common extends BaseController
{
    public function head()
    {
        return '访问失败';
    }
    public function foot()
    {
        return '访问失败';
    }
 
}