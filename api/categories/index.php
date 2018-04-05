<?php
  include_once('../../utils/head.php');

  $router->post(function($req, $res, $db, $util) {
    if(!$util->checkAuthorization($db)) {
      $res->send(403, '请先登陆后在进行操作');
      return ;
    }
    
    $params = $req['params'];
    $setParamsMsg = $util->isSetParams($params, ['name']);
    
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

    /** 获取分类列表 */
    $page = $params['page'] ? $params['page'] : 1;
    $pageSize = $params['pageSize'];
    
    if($pageSize) {
      $start = intval($pageSize) * (intval($page) - 1);
      $data = $db->select("SELECT * FROM category LIMIT $start, $pageSize");
    } else {
      $data = $db->select("SELECT * FROM category");
    }

    /** 获取特定分类详情 */
    $hasIdMsg = $util->isSetParams($params, ['int_id']);
    if($hasIdMsg['flag']) {
      $data = $db->select("SELECT * FROM category WHERE int_id = $params[int_id]");

      if($data) {
        $res->send(200, "获取分类信息成功", $data[0]);
        return ;
      } else {
        $res->send(400, "无该分类");
        return ;
      }
    }
    
    $total = $db->count('category', "");

    if($data) {
      $res->send(200, '获取分类列表成功', array("list"=> $data, "total"=> $total));
      return ;
    } else {
      $res->send(200, '无分类列表', array("list"=> [], "total"=> $total));
      return ;
    }
  });

  $router->put(function($req, $res, $db, $util) {
    if(!$util->checkAuthorization($db)) {
      $res->send(403, '请先登陆后在进行操作');
      return ;
    }

    $params = $req['params'];
    $setParamsMsg = $util->isSetParams($params, ['int_id']);

    if($setParamsMsg['flag']) {
      $result = $db->update('category', $params, "WHERE int_id = $params[int_id]");

      if($result) {
        $res->send(200, '更新分类信息成功');
      } else {
        $res->send(400, '更新分类信息失败');
      }
    } else {
      $res->send(400, "更新分类信息失败，缺少$setParamsMsg[key]参数");
    }
  });

  $router->delete(function($req, $res, $db, $util) {
    if(!$util->checkAuthorization($db)) {
      $res->send(403, '请先登陆后在进行操作');
      return ;
    }
    
    $params = $req['params'];
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