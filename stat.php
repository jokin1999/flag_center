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
    <style media="screen">
      .font-board-1 {
        font-size: 40px;
      }
      .font-board-2 {
        font-size: 40px;
      }
      .font-board-3 {
        font-size: 40px;
      }
      .font-board-4 {
        font-size: 30px;
      }
    </style>
  </head>
  <body>
    <!-- 幕布 -->
    <div class="container">

      <h1 class="my-4">夺旗排行榜</h1>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col" style="font-size: 30px;">排名</th>
            <th scope="col" style="font-size: 30px;">用户名</th>
            <th scope="col" style="font-size: 30px;">得分</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $key => $value): ?>
              <tr>
                <th scope="row">
                  <?php if ($count === 1): ?>
                    <?php echo "<font color=\"#ff3636\" font-weight=\"5px\" class=\"font-board-1\">".'#' . $count."</font>"; ?>
                  <?php elseif($count === 2): ?>
                    <?php echo "<font color=\"#ff8a00\" class=\"font-board-2\">".'#' . $count."</font>"; ?>
                  <?php elseif($count === 3): ?>
                    <?php echo "<font color=\"#4176ff\" class=\"font-board-3\">".'#' . $count."</font>"; ?>
                  <?php else: ?>
                    <?php echo "<font class=\"font-board-4\">".'#' . $count."</font>"; ?>
                  <?php endif; ?>
                </th>
                <th scope="row">
                  <?php if ($count === 1): ?>
                    <?php echo "<font color=\"#ff3636\" font-weight=\"5px\" class=\"font-board-1\">".$value['username']."</font>"; ?>
                  <?php elseif($count === 2): ?>
                    <?php echo "<font color=\"#ff8a00\" class=\"font-board-2\">".$value['username']."</font>"; ?>
                  <?php elseif($count === 3): ?>
                    <?php echo "<font color=\"#4176ff\" class=\"font-board-3\">".$value['username']."</font>"; ?>
                  <?php else: ?>
                    <?php echo "<font class=\"font-board-4\">".$value['username']."</font>"; ?>
                  <?php endif; ?>
                </th>
                <th scope="row">
                  <?php if ($count === 1): ?>
                    <?php echo "<font color=\"#ff3636\" font-weight=\"5px\" class=\"font-board-1\">".$value['count']."</font>"; ?>
                  <?php elseif($count === 2): ?>
                    <?php echo "<font color=\"#ff8a00\" class=\"font-board-2\">".$value['count']."</font>"; ?>
                  <?php elseif($count === 3): ?>
                    <?php echo "<font color=\"#4176ff\" class=\"font-board-3\">".$value['count']."</font>"; ?>
                  <?php else: ?>
                    <?php echo "<font class=\"font-board-4\">".$value['count']."</font>"; ?>
                  <?php endif; ?>
                </th>
              </tr>
              <?php $count++; ?>
            <?php endforeach; ?>
          </tr>
        </tbody>
      </table>

      <hr>

      <p>数据刷新于：<?php echo date("Y-m-d H:i:s"); ?></p>

    </div>
  </body>
</html>
