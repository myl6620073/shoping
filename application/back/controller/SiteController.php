<?php
/**
 * Created by PhpStorm.
 * User: myl
 * Date: 2018/6/21
 * Time: 23:57
 */

namespace app\back\controller;


use think\Controller;

class SiteController extends Controller
{

    public function indexAction()
    {
        echo '欢迎登陆';
    }

}