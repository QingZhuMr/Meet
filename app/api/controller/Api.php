<?php

declare(strict_types=1);

namespace app\api\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\Request;
use app\api\model\LoverModel;
use app\Request as AppRequest;
use app\api\validate\UserValidate; //验证
use app\api\model\UserModel; //模型
use think\facade\Session;
use think\middleware\Throttle;
use think\exception\ValidateException;

class Api extends BaseController
{
    protected $middleware = [
        throttle::class
    ];
    public function login() //登录接口
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
            // Session::set('user_id', $res['id']);
            // $user_id=$res['id'];
            // $uid = DB::name('user')->where("id",$res['id'])->find('id');
            return json($res);
        } else {
            return json($res);
        }

        // return View::fetch();
    }

    public function onMeet() //情侣配对
    {


        // if (!$this- > requestAccess ()) { 
        //     echo json ([ 'code'=>200, 'msg'=>'接口调用过于频繁' ])
        // };
        $data = Request::post();

        $user_id = Session::get('user_id');
        if ($data['id'] != $user_id) {
            return json(['code' => '1', 'info' => '操作与当前在线用户身份不符']);
        }

        $id = $data['id'];
        $userMeet = Db::name('user')->where('id', $id)->find();
        if ($userMeet["lock"] == 1) {
            return json(['code' => 0, 'info' => '您已经拥有了专属情侣!']);
        }
        $userId = $userMeet['id'];
        $userUsername = $userMeet['username'];
        $userSex = $userMeet['sex'];
        //$userYear = $userMeet['year'];
        $userProvince = $userMeet['province'];

        $userYear1 = $userMeet['year'] - 3;
        $userYear2 = $userMeet['year'] + 3;
        if ($userSex == 0) { //女性配对
            $userMeet = Db::name('user')
                ->where('sex', '1')
                ->where('lock', '0')
                ->where('islock', '0')
                ->where('province', $userProvince)
                ->where('year', 'between', [$userYear1, $userYear2])
                // ->withoutField('password')
                ->find();

            if ($userMeet == null) {
                return json(['code' => 1, 'info' => 'Ta还在与你奔赴的路上，请耐心等待哦~']);
            }

            $time = rand(1, 10);
            sleep($time);
            $lover['man'] = $userMeet['id']; //男方ID
            $lover['woman'] = $userId; //女方ID
            $lover['manUsername'] = $userMeet['username']; //男方昵称
            $lover['womanUsername'] = $userUsername; //女方昵称
            $lover['time'] = time(); //开始时间
            $lover['lid'] = substr(md5($lover['time']), 0, 6); //情侣唯一识别码
            $db = new LoverModel();
            $res = $db->addLover($lover);

            if ($res['code'] == 0) {
                $lock = DB::name('user')->where("id", $userId)->update(["lock" => '1', "islock" => '1', "lid" => $lover['lid']]);
                $lock2 = DB::name('user')->where("id", $userMeet['id'])->update(["lock" => '1', "islock" => '1', "lid" => $lover['lid']]);
                if ($lock || $lock2) {
                    return json($res);
                } else {
                    return json(['code' => '1', 'info' => '更新关系出现意外']);
                }
            } else {
                return json($res);
            }
        }
        if ($userSex == 1) { //男性配对
            $userMeet = Db::name('user')
                ->where('sex', '0')
                ->where('lock', '0')
                ->where('islock', '0')
                ->where('province', $userProvince)
                ->where('year', 'between', [$userYear1, $userYear2])
                // ->withoutField('password')
                ->find();

            if ($userMeet == null) {
                return json(['code' => 1, 'info' => 'Ta还在与你奔赴的路上，请耐心等待哦~']);
            }

            $time = rand(1, 10);
            sleep($time);

            $lover['man'] = $userId; //男方ID
            $lover['woman'] = $userMeet['id']; //女方ID
            $lover['manUsername'] = $userUsername; //男方昵称
            $lover['womanUsername'] = $userMeet['username']; //女方昵称
            $lover['time'] = time(); //开始时间
            $lover['lid'] = substr(md5($lover['time']), 0, 10); //情侣唯一识别码
            $db = new LoverModel();
            $res = $db->addLover($lover);

            if ($res['code'] == 0) {
                $lock = DB::name('user')->where("id", $userId)->update(["lock" => '1', "islock" => '1', "lid" => $lover['lid']]);
                $lock2 = DB::name('user')->where("id", $userMeet['id'])->update(["lock" => '1', "islock" => '1', "lid" => $lover['lid']]);
                if ($lock || $lock2) {
                    return json($res);
                } else {
                    return json(['code' => '1', 'info' => '更新关系出现意外']);
                }
            } else {
                return json($res);
            }
        }
    }

    public function myMeet() //我的情侣 
    {
        $data = Request::get();
        $id = $data['id'];
        // Session::has('user_id');
        // if(Session::has('user_id')!=true){
        //     json(['code'=>'401']);
        // };
        $sex = 1;
        $lid = '148e820111';
        // $sex = $data['sex'];
        // $lid = $data['lid'];
        if ($sex == 0) { //如果是女用户
            $sexNew = 1;
        }
        if ($sex == 1) { //如果是男用户
            $sexNew = 0;
        }
        $user = Db::name('user')->where("lid", $lid)->where('sex', $sexNew)->withoutField('password,phone')->find();
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
        if ($user['sign'] == null) {
            $user['sign'] = "暂无个性签名";
        }
        $lovers = DB::name('lovers')->where('lid', $user['lid'])->find();
        $user["timeEnd"] = $lovers["time"] + 259200;
        $user["timeEnd"] = date('Y年m月d日 H:m', $user["timeEnd"]);
        return json(['code' => '0', 'data' => $user]);
    }

    public function islock() //被遇见设置接口
    {
        $data = Request::post();
        $id = $data['id'];
        $user_id = Session::get('user_id');
        if ($data['id'] != $user_id) {
            return json(['code' => '1', 'info' => '操作与当前在线用户身份不符']);
        }
        if ($data['lock'] == 1) {
            return json(['code' => '1', 'info' => '已有情侣状态下，无法被遇见']);
        }
        if ($data['islock'] == 0) { //关闭
            $islock = 1;
        } else if ($data['islock'] == 1) { //开启
            $islock = 0;
        } else {
            return json(['code' => '1', 'info' => '数据传输错误']);
        }
        $res = Db::name('user')->where("id", $id)->update(["islock" => $islock]);
        if ($res) {
            if ($islock == 1) {
                return json(['code' => '0', 'info' => '已为你关闭被遇见']);
            }
            if ($islock == 0) {
                return json(['code' => '0', 'info' => '已为你开启被遇见']);
            }
        }
    }
    public function quit() //退出登录接口
    {
        $data = Request::post();
        $user_id = Session::get('user_id');
        if ($data['id'] != $user_id) {
            return json(['code' => '1', 'info' => '操作与当前在线用户身份不符']);
        }
        Session::delete('user_id', $data['id']);
        return json(['code' => '0', 'info' => '退出当前账号成功']);
    }

    // public function myMeet() //测试接口
    // {
    //     $data = Request::get();
    //     $id = $data['id'];
    //     $res = Db::name('user')->where('id', $id)->withoutField('password,phone')->find();
    //     $byear = $res['year'];
    //     $bmonth = $res['month'];
    //     $bday = $res['day'];

    //     $tyear = date('Y');
    //     $tmonth = date('m');
    //     $tday = date('d');

    //     $age = $tyear - $byear;
    //     if ($bmonth > $tmonth || $bmonth == $tmonth && $bday > $tday) {
    //         $age--;
    //     }
    //     $res['age'] = $age;
    //     if ($res['sign'] == null) {
    //         $res['sign'] = "暂无个性签名";
    //     }
    //     return json($res);
    // }
}
