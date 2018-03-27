<?php
  include_once('../../utils/head.php');

  $router->post(function($req, $res, $db, $util) {
    $params = $req['params'];
    $setParamsMsg = $util->isSetParams($params, ['name', 'property']);
    
    if($setParamsMsg['flag']) {
      $result = $db->insert('category', $params);

      if($result) {
        $res->send(200, '添加分类成功');
      } else {
        $res->send(400, '添加分类失败');
      }
    } else {
      $res->send(400, "缺少$setParamsMsg[key]参数");
    }
  });

  $router->get(function($req, $res, $db, $util) {
    $params = $req['params'];
    $page = $params['page'] || 1;
    $pageSize = $params['pageSize'];
    
    if($pageSize) {
      $start = $pageSize * ($page - 1);
      $data = $db->select("SELECT * FROM category LIMIT $start, $pageSize");
    } else {
      $data = $db->select("SELECT * FROM category");
    }
    
    $total = $db->count('category', "");

    if($data) {
      $res->send(200, '获取分类列表成功', array("list"=> $data, "total"=> $total));
    } else {
      $res->send(400, '获取分类列表失败');
    }
  });

  $router->delete(function($req, $res, $db, $util) {
    $params = req['params'];
    $setParamsMsg = $util->isSetParams($params, ['int_id']);

    if($setParamsMsg['flag']) {
      $result = $db->delete('category', "WHERE int_id = $params[int_id]");

      if($result) {
        $res->send(200, '删除分类成功');
      } else {
        $res->send(400, '删除分类失败');
      }
    } else {
      $res->send(400, "删除分类失败，缺少$setParamsMsg[key]参数");
    }
  });
?>