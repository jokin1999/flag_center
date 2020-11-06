<?php
// +----------------------------------------------------------------------
// | Constructed by Jokin [ Think & Do & To Be Better ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2019 Jokin All rights reserved.
// +----------------------------------------------------------------------
// | Author: Jokin <Jokin@twocola.com>
// +----------------------------------------------------------------------

// JSON头
header("Content-Type: application/json");

// 控制模块
include './controlCenter.php';

// 获取签到令牌
if (isset($_GET['username']) && !empty($_GET['username'])
    && isset($_GET['password']) && !empty($_GET['password'])
    && isset($_GET['flag']) && !empty($_GET['flag'])
  ) {
  $username = $_GET['username'];
  $password = $_GET['password'];
  $flag = $_GET['flag'];
}else{
  die(control::generateJson(null, 403, 'Username and token required but not given.'));
}

$control = new control();
$result = $control->subflag($username, $password, $flag);
if ($result === 100) {
  $result_json = control::generateJson($result, 403, '用户名密码不正确');
}else if($result === 101) {
  $result_json = control::generateJson($result, 403, 'Flag提交过快');
}else if($result === 101) {
  $result_json = control::generateJson($result, 403, 'Flag提交过快');
}else if($result === 200) {
  $result_json = control::generateJson($result, 200, '提交成功，Flag正确！');
}else if($result === 201) {
  $result_json = control::generateJson($result, 201, '提交成功，Flag错误！');
}else if($result === 202) {
  $result_json = control::generateJson($result, 202, '提交失败，该Flag已经提交并得分！');
}else{
  $result_json = control::generateJson($result, 404, '提交失败');
}

die($result_json);
?>
