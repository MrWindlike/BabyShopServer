<?php
  include_once('../../utils/head.php');

  $router->post(function($req, $res, $db, $util) {
    
    $params = $req['params'];
    $previews =  $_FILES['previews'];

    if ((($previews["type"] === "image/gif")
      || ($previews["type"] === "image/jpeg")
      || ($previews["type"] === "image/pjpeg")
      || ($previews["type"] === "image/png"))
      && ($previews["size"] < 2000000)){
        $fileName = base64_encode(date("y-m-d h:i:s", time()).$previews['name']).".jpg";
        $result =move_uploaded_file($previews["tmp_name"], "../../upload/previews/".$fileName);

        if($result) {
          $res->send(200, '上传预览图成功', array("fileName"=> $fileName));
        } else {
          $res->send(400, '上传预览图失败');
        }
      }
    
  });
?>