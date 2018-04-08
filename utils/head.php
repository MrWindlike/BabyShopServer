<?php
  include_once 'router.php';
  error_reporting(E_ALL^E_NOTICE^E_WARNING);
  date_default_timezone_set("Asia/Shanghai");
  header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
  header("Access-Control-Allow-Headers: Authorization,Origin, X-Requested-With, Content-Type, Accept");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Origin: http://localhost:8000");
  if(strtoupper($_SERVER['REQUEST_METHOD']) == 'OPTIONS'){
    exit;
  }
  
?>