<?

namespace app\api\model;

use think\Model;
use think\Db;

class UserModel extends Model
{
    protected $table = 'user';


    public function addUsers($data) //用户注册接口
    {
        $tmp = UserModel::where('phone', '=', $data['phone'])->count();
        if ($tmp) {
            return ['code' => 1, 'info' => '该手机号码已被注册'];
        }

        $rand_str = bin2hex(random_bytes(8));
        $data['password'] = md5($data['password']);
        $data['addtime'] = time();
       // $data['city'] = null;
        // $data['username'] = "用户" . $rand_str;

        $num = rand(1,10);

        $user           = new UserModel;
        $user->username = $data['username'];
        $user->phone    = $data['phone'];
        $user->password = $data['password'];
        $user->addtime = $data['addtime'];
        $user->work = $data['work'];//工作
        $user->province = $data['province'];//省份
        //$user->city = $data['city'];//城市
        $user->year = $data['year'];//年
        $user->month = $data['month'];//月
        $user->day = $data['day'];//天
        $user->sex = $data['sex'];//性别
       // $user->education = $data['education'];//学历
       // $user->school = $data['school'];//学校
        $user->height = $data['height'];//身高
        $user->initialize = '1';
        $user->avatar = '/static/images/momo/'.$num.'jpg';
        $user->background = '/static/images/bg/bg.jpg';
        $user->save();
        $id = $user->id;
        if ($id == null) {
            return ['code' => 1, 'info' => '注册失败'];
        }

        return ['code' => 0, 'info' => '注册成功', 'id' => $id];
    }

    public function getUsersLogin($data) //用户登录接口
    {
        $tmp = UserModel::where('phone', '=', $data['phone'])->find();
        if ($tmp) {
            $data['password'] = md5($data['password']);
            if ($tmp['password'] != $data['password']) {
                return ['code' => 1, 'info' => '密码错误'];
            }
            return ['code' => 0, 'info' => '登录成功', 'id' => $tmp['id']];
        } else {
            return ['code' => 1, 'info' => '该手机号码不存在'];
        }
    }

    

    // public function infoUsers($data) //用户资料修改接口
    // {
    //     $data['initialize'] = '1';
    //     $user = new UserModel;
    //     $user->username = $data['username'];
    //     $user->height = $data['height'];
    //     $user->city = $data['city'];
    //     $user->education = $data['education'];
    //     $user->work = $data['work'];
    //     $user->update();
    // }
}
