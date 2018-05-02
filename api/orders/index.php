<?php
  include_once('../../utils/head.php');

  $router->post(function($req, $res, $db, $util) {
    $params = $req['params'];
    $setParamsMsg = $util->isSetParams($params, ['weixinId', 'addressId', 'goodIdList', 'password']);

    if($setParamsMsg['flag']) {
      if($params['password'] != '123456') {
        $res->send(403, '密码错误');
        die;
      }

      $order = [];
      $order['weixinId'] = $params['weixinId'];
      $order['int_addressId'] = $params['addressId'];
      $order['id'] = date('YmdHis') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_RIGHT);
      $order['float_time'] = time();
      $order['int_status'] = 0;

      $result = $db->insert('order', $order);

      foreach($params['goodIdList'] as $index => $goodId) {
        $price = $db->select("SELECT float_price FROM good WHERE int_id = $goodId")[0]['price'];
        $db->insert('commodity', array("orderId"=> $order['id'], "int_goodId"=> $goodId, "float_price"=> $price));
      }

      if($result) {
        $res->send(200, '下订单成功');
      } else {
        $res->send(400, '下订单失败');
      }
    } else {
      $res->send(400, "下订单失败，缺少$setParamsMsg[key]参数");
    }
  });

  $router->get(function($req, $res, $db, $util) {
    $params = $req['params'];
    $setParamsMsg = $util->isSetParams($params, ['weixinId']);

    if($setParamsMsg['flag']) {
      $data = $db->select("SELECT * FROM `order` WHERE weixinId = '$params[weixinId]'");

      $res->send(200, "获取订单成功", $data);
      return ;
    }

    if(!$util->checkAuthorization($db)) {
      $res->send(403, '请先登陆后在进行操作');
      return ;
    }

    $page = $params['page'] ? $params['page'] : 1;
    $pageSize = $params['pageSize'] ? $params['pageSize'] : 8;
    $start = intval($pageSize) * (intval($page) - 1);

    $data = $db->select("SELECT * FROM `order` LIMIT $start, $pageSize");
    $total = $db->count('order', '');

    if($data) {
      $res->send(200, '获取订单成功', array("list"=> $data, "total"=> $total));
      return ;
    } else {
      $res->send(200, '获取订单成功', array("list"=> [], "total"=> 0));
      return ;
    }

    $res->send(400, '获取订单失败');
  });

  $router->put(function($req, $res, $db, $util) {
    $params = req['params'];
    $setParamsMsg = $util->isSetParams($params, ['int_status', 'orderId']);

    if($setParamsMsg['flag']) {
      $result = $db->update('order', array("int_status"=> $params['int_status']), "WHERE orderId = '$params[orderId]'");

      if($result) {
        $res->send(200, '更新订单成功');
        die;
      } else {
        $res->send(400, '更新订单失败');
        die;
      }
    }

    $res->send(400, '更新订单失败');
});
?>