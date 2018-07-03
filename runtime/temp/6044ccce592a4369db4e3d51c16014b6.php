<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:61:"D:\thinkphp5\public/../application/back\view\admin\login.html";i:1529594782;}*/ ?>
<!DOCTYPE html>
<html dir="ltr" lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <title>后台管理系统</title>
    <base href="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <link href="/static/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="/static/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
    <link href="/static/back/css/stylesheet.css" type="text/css" rel="stylesheet" media="screen" />
    <script type="text/javascript" src="/static/jquery/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="/static/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div id="container">
    <header id="header" class="navbar navbar-static-top">
        <div class="navbar-header">
            <a href="" class="navbar-brand"><img src="/static/back/image/logo.png" alt="BuyPlus" title="BuyPlus" /></a></div>
    </header>
    <div id="content">
        <div class="container-fluid"><br />
            <br />
            <div class="row">
                <div class="col-sm-offset-4 col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 class="panel-title">
                                <i class="fa fa-lock"></i> <?php echo (isset($message ) && ($message  !== '')?$message :'请输入您的登录信息'); ?>
                            </h1>
                        </div>
                        <div class="panel-body">
                            <form action="<?php echo url('login'); ?>" method="post">
                                <div class="form-group">
                                    <label for="input-username">管理员</label>
                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input type="text" name="username" value="<?php echo (isset($data['username']) && ($data['username'] !== '')?$data['username']:''); ?>" placeholder="管理员" id="input-username" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-password">密码</label>
                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input type="password" name="password" value="" placeholder="密码" id="input-password" class="form-control" />
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-key"></i> 登录</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer id="footer">
        <a href="http://www.hellokang.net">BuyPlus(败家Shopping) HelloKang</a>
        <br>
        &copy; 2009-2016 All Rights Reserved.
        <br>Version 1.0
    </footer></div>
</body></html>
