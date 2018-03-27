<?php
  include_once('../../utils/head.php');

  $router->post(function($req, $res, $db, $util) {
    $params = $req['params'];
    $previews =  $_FILES['previews'];

    echo var_dump($previews);
  });
?>