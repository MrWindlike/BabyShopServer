<?php
  include_once('../../utils/head.php');

  $router->post(function($req, $res, $db, $util) {
    $params = $req['params'];
    $setParamsMsg = $util->isSetParams($params, ['username', 'password']);

    if($setParamsMsg['flag']) {
      $user = $db->select("SELECT int_id FROM admin WHERE username = '$params[username]' AND password = md5('$params[password]')")[0];

      if($user) {
        $ms = $util->getMs();
        $token = md5("$params[password].$ms");
        $result = $db->update('admin', ["token"=> $token, "float_time"=> $ms], "WHERE int_id = $user[id]");

        if($result) {
          $res->send(200, '登陆成功', array("token"=> $token));
          return ;
        } else {
          $res->send(400, '登陆失败');
          return ;
        }
      } else {
        $res->send(400, '用户名或密码错误');
      }
    } else {
      if($setParamsMsg['key'] === 'username') {
        $res->send(400, '请输入用户名');
        return ;
      } else if($setParamsMsg['key'] === 'password') {
        $res->send(400, '请输入密码');
        return ;
      }
    }
  });

  $router->delete(function($req, $res, $db, $util) {
    $admin = $util->checkAuthorization($db);

    if($admin) {
      $db->update('admin', array("token"=> '', "float_time"=> 0), "WHERE int_id = $admin[id]");
      $res->send(200, '注销成功');
      return ;
    } else {
      $res->send(400, '注销失败');
    }
  });
?>