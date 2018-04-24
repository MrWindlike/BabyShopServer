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
            $res->send(200, "获取购物车中的商品列表成功", array("list"=> $data));
            return ;
        } else {
            $res->send(200, "购物车下无商品", array("list"=> []));
            return ;
        }
    }else{
        $res->send(400, "缺少$setParamsMsg[key]参数");
    }
  });

$router->put(function($req, $res, $db, $util) {
  $params = $req['params'];
  
  $setParamMsg = $util->isSetParams($params, ['weixinId', 'int_num', 'int_goodid']);

  if($setParamMsg['flag']) {
    if($params['int_num'] <= 0) {
      $res->send(400, '操作失败，数量必须大于零');
      die;
    }

    $result = $db->update('cart', array("int_num"=> $params['int_num']), "WHERE weixinId = '$params[weixinId]' AND int_goodid = $params[int_goodid]");

    if($result) {
      $res->send(200, '操作成功');
      die;
    } else {
      $res->send(400, '操作失败');
      die;
    }
  } else {
    $res->send(400, "操作失败，缺少$setParmasMsg[key]参数");
    die;
  }
});

$router->delete(function($req, $res, $db, $util) {
  $params = $req['params'];
  
  $setParamMsg = $util->isSetParams($params, ['weixinId', 'int_goodid']);

  if($setParamMsg['flag']) {
    $result = $db->delete('cart', "WHERE weixinId = '$params[weixinId]' AND int_goodid = $params[int_goodid]");

    if($result) {
      $res->send(200, '操作成功');
    } else {
      $res->send(400, '操作失败');
    }
  } else {
    $res->send(400, "操作失败，缺少$setParmasMsg[key]参数");
  }
});
?>