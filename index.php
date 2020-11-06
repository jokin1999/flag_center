<?php
// +----------------------------------------------------------------------
// | Constructed by Jokin [ Think & Do & To Be Better ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2020 Jokin All rights reserved.
// +----------------------------------------------------------------------
// | Author: Jokin <Jokin@twocola.com>
// +----------------------------------------------------------------------

// 控制模块
include './controlCenter.php';

// 生成签到令牌
$list = new control();
$list = $list->getCharts();
$count = 1;
?>

<!DOCTYPE html>
<html lang="zh-CN" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="./icon.ico">
    <title>Flag提交平台</title>
    <link rel="stylesheet" href="./assets/bootstrap.min.css">
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/bootstrap.bundle.min.js" charset="utf-8"></script>
    <script type="text/javascript">
      refresh = setInterval(function(){
        location.href='';
      }, 60 * 1000);
    </script>
  </head>
  <body>
    <!-- 幕布 -->
    <div class="jumbotron">
      <div class="container">
        <h1 class="display-4">Flag Center</h1>
        <hr class="my-4">
        <p class="lead">
          <a class="btn btn-success" href="./register.html" target="_blank" role="button">注册账户</a>
          <a class="btn btn-primary" href="./web_checkin.html" target="_self" role="button">提交Flag</a>
        </p>
      </div>
    </div>
    <div class="container">

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">排名</th>
            <th scope="col">UID</th>
            <th scope="col">用户名</th>
            <th scope="col">得分</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $key => $value): ?>
              <tr>
                <th scope="row">
                  <?php echo '#' . $count; ?>
                </th>
                <th scope="row">
                  <?php echo $value['uid']; ?>
                </th>
                <th scope="row">
                  <?php if ($count === 1): ?>
                    <?php echo "<font color=\"#ff8a00\" font-weight=\"5px\">".$value['username']."</font>"; ?>
                  <?php elseif($count === 2): ?>
                    <?php echo "<font color=\"#4176ff\">".$value['username']."</font>"; ?>
                  <?php elseif($count === 3): ?>
                    <?php echo "<font color=\"#ff397b\">".$value['username']."</font>"; ?>
                  <?php else: ?>
                    <?php echo $value['username']; ?>
                  <?php endif; ?>
                </th>
                <th scope="row">
                  <?php echo $value['count']; ?>
                </th>
              </tr>
              <?php $count++; ?>
            <?php endforeach; ?>
          </tr>
        </tbody>
      </table>

    </div>
  </body>
</html>
