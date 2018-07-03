<?php
/**
 * Created by PhpStorm.
 * User: Kang
 * Date: 2018/06/12
 * Time: 22:37
 */

namespace app\back\validate;

use think\Validate;

class AdminValidate extends Validate
{
    // 规则数组
    protected $rule = [
        ## 令牌校验
        '__token__' => 'require|token',
        # 自定义规则
        'password' => 'require',
        'password_confirm' => 'require|confirm:password',
    ];

    // 字段名称翻译
    protected $field = [
        'id' => 'ID',
        'username' => '用户名',
        'password' => '密码',
        'password_confirm'=>'确认密码',
        'sort' => '排序',
        'create_time' => '创建时间',
        'update_time' => '修改时间',

    ];
}