<?php
  include_once('../../utils/head.php');
  
  /** 获取地址列表 */
  $router->get(function($req, $res, $db, $util) {
    $params = $req['params'];

    if($util->isSetParams($params, ['weixinId'])['flag']) {
      $list = $db->select("SELECT * FROM address WHERE weixinId = '$params[weixinId]'");

      if($list) {
        $res->send(200, '获取地址列表成功', array("list"=> $list));
      } else {
        $res->send(200, '无地址信息', []);
      }
    } else {
      $res->send(400, '获取地址列表失败');
    }
    
  });

  /** 新增地址 */
  $router->post(function($req, $res, $db, $util) {
    $params = $req['params'];
    $default = false;

    /** 判断信息是否完整 */
    if($util->isSetParams($params, ['weixinId', 'name', 'phone', 'province', 'city', 'county', 'detail'])['flag']) {
      /** 如果该用户没有地址，则设该地址为默认地址 */
      if($db->count('address', "WHERE weixinId = '$params[weixinId]'") === 0) {
        $default = true;
      }

      if($util->checkPhone($params['phone'])) {
        $params['bool_default'] = $default;
        $result = $db->insert('address', $params);
      } else {
        $result = false;
        $res->send(400, '手机号码格式错误', []);
        return ;
      }
      

      if($result) {
        $res->send(200, '添加地址成功', []);
        return ;
      } else {
        $res->send(400, '添加地址失败', []);
        return ;
      }
    } else {
      $res->send(400, '信息填写不完整', []);
      return ;
    }
  });

  /** 更新地址信息 */
  $router->put(function($req, $res, $db, $util) {
    // echo var_dump($req['params']);
    $params = $req['params'];
    $paramsMsg = $util->isSetParams($params, ['weixinId', 'int_id']);

    if($paramsMsg['flag']) {
      /** 设置为默认地址 */
      $cancelResult = $db->update('address', array("bool_default"=> 0), "WHERE weixinId = '$params[weixinId]' AND bool_default = 1");
      $updateResult = $db->update('address', array("bool_default"=> 1), "WHERE weixinId = '$params[weixinId]' AND int_id = $params[int_id]");
      
      if($cancelResult && $updateResult) {
        $res->send(200, '设置默认地址成功', []);
        return ;
      } else {
        $res->send(400, '设置默认地址失败', []);
        return ;
      }
    } else {
      $res->send(400, "设置默认地址失败，缺少$paramsMsg[key]参数", []);
      return ;
    }
    
    $paramsMsg = $util->isSetParams($params, ['weixinId', 'int_id', 'name', 'phone', 'province', 'city', 'county', 'detail']);

    if($paramsMsg['flag']) {
      /** 更新地址信息 */
      if($util->checkPhone($params['phone'])) {
        $params['bool_default'] = $default;
        $result = $db->update('address', $params, "WHERE int_id = $params[int_id] AND weixinId = $params[weixinId]");
      } else {
        $result = false;
        $res->send(400, '手机号码格式错误', []);
        return ;
      }
      
      if($result) {
        $res->send(200, '更新地址信息成功', []);
        return ;
      } else {
        $res->send(400, '更新地址信息失败', []);
        return ;
      }
    } else {
      $res->send(400, "信息填写不完整", []);
      return ;
    }
  });

  /** 删除地址 */
  $router->delete(function($req, $res, $db, $util) {
    $params = $req['params'];
    $paramsMsg = $util->isSetParams($params, ['weixinId', 'int_id', 'bool_default']);

    if($paramsMsg['flag']) {
      
      if($params['bool_default']) {
        /** 如果删除的是默认地址，则寻找是否还有其他地址，设ID最小的为默认地址 */
      } else {
        /** 如果删除的不是默认地址，则直接删除 */
        $result = $db->delete('address', "WHERE weixinId = '$params[weixinId]' AND int_id = $params[int_id]");

        if($result) {
          $res->send(200, "删除地址成功");
        } else {
          $res->send(400, "删除地址失败");
        }
      }
    } else {
      $res->send(400, "删除地址失败，缺少$paramsMsg[key]参数");
    }
  });
?>