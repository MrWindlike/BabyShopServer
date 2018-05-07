<?php
  include_once('../../utils/head.php');

  $router->post(function($req, $res, $db, $util) {
    $params = $req['params'];
    $setParamsMsg = $util->isSetParams($params, ['weixinId', 'addressId', 'goodList', 'password']);

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

      foreach($params['goodList'] as $index => $good) {
        $price = $db->select("SELECT float_price FROM good WHERE int_id = $good[id]")[0]['price'];
        
        if($params['isFromCart']) {
          $db->delete('cart', "WHERE weixinId = '$params[weixinId]' AND int_goodid = $good[id]");
        }

        if(!$price) {
          $res->send(400, '所选商品不存在');
          die;
        }

        $db->insert('commodity', array("orderId"=> $order['id'], "int_goodId"=> $good['id'], "int_num"=> $good['num'], "float_price"=> $price));
      }

      $result = $db->insert('order', $order);

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
      $orders = $db->select("SELECT * FROM `order` WHERE weixinId = '$params[weixinId]'");

      foreach($orders as $index => $order) {
        $orders[$index]['goodList'] = $db->select("SELECT int_goodId, int_num, float_price FROM `commodity` WHERE orderId = '$order[id]'");

        foreach($orders[$index]['goodList'] as $goodIndex => $good) {
          $selectedGood = $db->select("SELECT name, preview FROM `good` WHERE int_id = $good[goodId]")[0];
          $orders[$index]['goodList'][$goodIndex]['name'] = $selectedGood['name'];
          $orders[$index]['goodList'][$goodIndex]['preview'] = $selectedGood['preview'];
        }
      }

      $res->send(200, "获取订单成功", array("list"=> $orders));
      return ;
    }

    if(!$util->checkAuthorization($db)) {
      $res->send(403, '请先登陆后在进行操作');
      return ;
    }

    $page = $params['page'] ? $params['page'] : 1;
    $pageSize = $params['pageSize'] ? $params['pageSize'] : 8;
    $start = intval($pageSize) * (intval($page) - 1);

    $orders = $db->select("SELECT * FROM `order` ORDER BY id DESC LIMIT $start, $pageSize");

    foreach($orders as $index => $order) {
      $orders[$index]['goodList'] = $db->select("SELECT int_goodId, int_num, float_price FROM `commodity` WHERE orderId = '$order[id]'");
      
      foreach($orders[$index]['goodList'] as $goodIndex => $good) {
        $selectedGood = $db->select("SELECT name, preview FROM `good` WHERE int_id = $good[goodId]")[0];
        $orders[$index]['goodList'][$goodIndex]['name'] = $selectedGood['name'];
        $orders[$index]['goodList'][$goodIndex]['preview'] = $selectedGood['preview'];
      }
      
      $orders[$index]['address'] = $db->select("SELECT * FROM `address` WHERE int_id = $order[addressId]")[0];
    }
    
    $total = $db->count('order', '');

    if($orders) {
      $res->send(200, '获取订单成功', array("list"=> $orders, "total"=> $total));
      return ;
    } else {
      $res->send(200, '获取订单成功', array("list"=> [], "total"=> 0));
      return ;
    }

    $res->send(400, '获取订单失败');
  });

  $router->put(function($req, $res, $db, $util) {
    $params = $req['params'];
    $setParamsMsg = $util->isSetParams($params, ['int_status', 'id']);

    if($setParamsMsg['flag']) {
      $result = $db->update('order', array("int_status"=> $params['int_status']), "WHERE id = '$params[id]'");

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