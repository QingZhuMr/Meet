<?

namespace app\api\validate;

use think\Validate;

class UserValidate extends Validate
{
    protected $rule =   [
        'username'  => 'chsAlphaNum|length:1,16',
        'password'   => 'length:6,30',
        'height'   => 'number|length:3',
        'verifyCode'   => 'length:4',
        'email' => 'email',
        'phone' => 'mobile|number|length:11',
        'school'  => 'chsAlpha|length:3,30',
        'city'  => 'chsAlpha|length:2,30',
        'province' => 'chsAlpha|length:2,30',
        'work' => 'chsAlpha|length:2,30',
        'education' => 'chsAlpha|length:2,30',
        'year'   => 'number|length:4',
        'month'   => 'number|length:1,2',
        'day'   => 'number|length:1,2',
    ];

    protected $message  =   [
        // 'username.require' => '用户名必须填写',
        'username.chsAlphaNum'     => '昵称只能是汉字、字母和数字',
        'username.length'     => '昵称长度范围1-16个字符',
        'school.chsAlpha'     => '学校名称只能是汉字、字母',
        'school.length'     => '学校名称长度范围3-30个字符',
        'city.chsAlpha'     => '城市名称只能是汉字、字母',
        'city.length'     => '城市名称长度范围2-30个字符',
        'city.province'     => '城市名称只能是汉字、字母',
        'city.province'     => '城市名称长度范围2-30个字符',
        'city.work'     => '工作名称只能是汉字、字母',
        'city.work'     => '工作名称长度范围2-30个字符',
        'city.education'     => '学历名称只能是汉字、字母',
        'city.education'     => '学历名称长度范围2-30个字符',
        'year.number'   => '年份只能是纯数字',
        'month.number'   => '月份只能是纯数字',
        'day.number'   => '日份只能是纯数字',
        'year.length'     => '年份必须为4个字符',
        'month.length'     => '月份必须为1-2个字符',
        'day.length'     => '日份必须为1-2个字符',

        // 'password.require'   => '密码必须填写',
        'password.length'   => '密码必须6-30个字符',
        'height.number'   => '身高只能是纯数字',
        'height.length'   => '身高必须为3个数字',
        // 'verifyCode.require'   => '验证码必须填写',
        'verifyCode.length'   => '验证码必须5位',
        'phone.mobile'  => '填写有效的手机',
        'phone.number'  => '手机只能数字',
        'phone.length'  => '手机只能11位数字',
        'email'        => '邮箱格式错误',
    ];
}
