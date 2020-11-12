<?php
// +----------------------------------------------------------------------
// | Constructed by Jokin [ Think & Do & To Be Better ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2019 Jokin All rights reserved.
// +----------------------------------------------------------------------
// | Author: Jokin <Jokin@twocola.com>
// +----------------------------------------------------------------------

// 控制模块
include './controlCenter.php';

// 获取签到令牌
if (isset($_POST['username']) && !empty($_POST['username'])
    && isset($_POST['password']) && !empty($_POST['password'])
    && isset($_POST['comfirm']) && !empty($_POST['comfirm'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $comfirm = $_POST['comfirm'];
}else{
  die('提交的信息不完全，注册失败！');
}
// 检查
if (mb_strlen($username) > 16 || mb_strlen($username) < 2){
  die('用户名长度不得超过16位，不得低于2位！');
}
if (mb_strlen($password) > 16 || mb_strlen($password) < 6){
  die('密码长度不得超过16位，不得低于6位！');
}
if ($password !== $comfirm){
  die('两次密码不一致！');
}
// 生成签到令牌
$control = new control();
$result = $control->registerAccount($username, $password);
if ($result){
  // header("location:./index.php");
  echo "<script type='text/javascript'>alert('注册成功！点击确定3秒后自动跳转');setTimeout('location.href=\"./index.php\"', 3000);</script>";
}else{
  die("用户名可能已经存在！");
}
?>
