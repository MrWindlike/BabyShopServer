<?php
  include_once('../../utils/head.php');

  $router->post(function($req, $res, $db, $util) {
    $params = $req['params'];
    $setParamsMsg = $util->isSetParams($params, ['name', 'float_price', 'preview', 'detail', 'bool_hot', 'bool_recomment', 'int_categoryId']);

    if($setParamsMsg['flag']) {
      $result = $db->insert('good', $params);

      if($result) {
        $res->send(200, '添加商品成功');
      } else {
        $res->send(400, '添加商品失败');
      }
    } else {
      $res->send(400, "添加商品失败, 缺少$setParamsMsg[key]参数");
    }
  });

  $router->get(function($req, $res, $db, $util) {
    $params = $req['params'];

    /** 获取商品详情 */
    $hasIdMsg = $util->isSetParams($params, ['int_id']);
    if($hasIdMsg['flag']) {
      $data = $db->select("SELECT * FROM good WHERE int_id = $params[int_id]");

      if($data) {
        $res->send(200, '获取商品详情成功', $data[0]);
        return ;
      } else {
        $res->send(400, '没有该商品');
        return ;
      }
    }

    /** 获取热门列表 */
    $hasHotMsg = $util->isSetParams($params, ['bool_hot']);
    if($hasHotMsg['flag']) {
      $params['bool_hot'] = intval($params['bool_hot']);
      $data = $db->select("SELECT int_id, name, float_price, preview, int_categoryId FROM good WHERE bool_hot = $params[bool_hot]");

      if($data) {
        $res->send(200, '获取商品热门列表成功', array("list"=> $data));
        return ;
      } else {
        $res->send(400, '无热门列表商品');
        return ;
      }
    }

    /** 获取推荐列表 */
    $hasRecommentMsg = $util->isSetParams($params, ['bool_recomment']);
    if($hasRecommentMsg['flag']) {
      $params['bool_recomment'] = intval($params['bool_recomment']);
      $data = $db->select("SELECT int_id, name, float_price, preview, int_categoryId FROM good WHERE bool_recomment = $params[bool_recomment]");

      if($data) {
        $res->send(200, '获取商品推荐列表成功', array("list"=> $data));
        return ;
      } else {
        $res->send(400, '无推荐列表商品');
        return ;
      }
    }

    /** 获取商品分类列表 */
    $hasCategoryMsg = $util->isSetParams($params, ['int_categoryId']);
    if($hasCategoryMsg['flag']) {
      $params['bool_recomment'] = intval($params['bool_recomment']);
      $data = $db->select("SELECT int_id, name, float_price, preview, int_categoryId FROM good WHERE int_categoryId = $params[int_categoryId]");

      if($data) {
        $res->send(200, '获取商品分类列表成功', array("list"=> $data));
        return ;
      } else {
        $res->send(400, '该分类下无商品');
        return ;
      }
    }

    /** 获取商品列表 */
    $data = $db->select("SELECT int_id, name, float_price, preview, int_categoryId FROM good");

    if($data) {
      $res->send(200, '获取商品列表成功', array("list"=> $data));
      return ;
    } else {
      $res->send(400, '无商品列表');
      return ;
    }
  });
?>