<?php

/**
 * Created by PhpStorm.
 * User: myl
 * Date: 2018/6/23
 * Time: 16:16
 */
namespace app\back\behavior;
use priv\Privilege;
use think\Session;

class CheckAuth
{
    public function run(&$params)
    {
        $request = request();
        //特例的跳过
        $except = [
            'admin' => ['login','captcha'],
            'othercontroller' => ['']
        ];

        //如果设置了特例的控制器
        if(isset($except[strtolower($request->controller())])){
            //当前控制器中存在特例动作
            if(in_array($request->action(),$except[strtolower($request->controller())])){
                //动作是特例

                //不需要校验
                return;
            }
        }

        # 校验授权
        if (! Privilege::checkPriv($request->path())) {
            # 未授权
            redirect('back/admin/login', [], '302', [
                'message'=>'没有权限',
            ])->send();
            die;
        }

        #登录校验
        if(!Session::has('admin')){
            //未登录
            ## 记录之前的URL
            Session::set('route', $request->path());
            redirect('back/admin/login')->send();
            die;
        }
    }

    //退出
    public function logoutAction()
    {
        Session::delete('admin');
        $this->redirect('login');
    }
}