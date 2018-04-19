<?php
  include_once('../../utils/head.php');

  $router->post(function($req, $res, $db, $util) {
    $params = $req['params'];
    $setParamsMsg = $util->isSetParams($params, ['int_goodid','weixinId']);

    if($setParamsMsg['flag']) {
      $data = $db->select("SELECT int_num FROM cart WHERE int_goodid = $params[int_goodid]");
      
      if($data) {
        $result = $db->update('cart', array("int_num"=> $data[0]['num'] + 1), "WHERE int_goodid = $params[int_goodid]");
      } else {
        $newParams = $params;
        $newParams['int_num'] = 1;
        $result = $db->insert('cart', $newParams);
      }
      
      if($result) {
        $res->send(200, '加入购物车成功');
      } else {
        $res->send(400, '加入购物车失败');
      }
    } else {
      $res->send(400, "加入购物车失败, 缺少$setParamsMsg[key]参数");
    }
  });

  /**删除购物车中的商品 */
  $router->delete(function($req, $res, $db, $util) {
    $params = $req['params'];
    $setParamsMsg = $util->isSetParams($params, ['int_goodid','weixinId']);

    if($setParamsMsg['flag']) {
      $result = $db->delete('cart', "WHERE int_goodid = $params[int_goodid]");
      if($result) {
        $res->send(200, '删除商品成功');
      } else {
        $res->send(400, '删除商品失败');
      }
    } else {
      $res->send(400, "删除商品失败，缺少$setParamsMsg[key]参数");
    }
  });

  /**获取购物车列表 */
  $router->get(function($req, $res, $db, $util) {
    $params = $req['params'];  
    $setParamsMsg = $util->isSetParams($params, ['weixinId']); 
    
    if($setParamsMsg['flag']){
        $data = $db->select("SELECT * FROM cart WHERE weixinId = '$params[weixinId]'");
        foreach($data as $index => $cart) {
            $good = $db->select("SELECT * FROM good WHERE int_id = $cart[goodid]");
            $data[$index]['good'] = $good[0];
        }
        
        if($data) {
            $res->send(200, "获取购物车中的商品列表成功", $data);
            return ;
        } else {
            $res->send(400, "购物车下无商品");
            return ;
        }
    }else{
        $res->send(400, "缺少$setParamsMsg[key]参数");
    }
  });

?>