<?php
  include_once('../../utils/head.php');

  $router->get(function($req, $res, $db, $util) {
    $admin = $util->checkAuthorization($db);

    if($admin) {
      $res->send(200, '获取用户信息成功', $admin);
    } else {
      $res->send(403, '请先登陆后在进行操作');
      return ;
    }
  });
?>