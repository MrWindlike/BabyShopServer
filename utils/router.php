<?php
  include_once 'database.php';
  include_once 'response.php';
  include_once 'util.php';

  class Router {
    function get($fn) {

      if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $req = array(
          "params"=> $_GET
        );
        $res = new Response();
        $db = new Database();
        $util = new Util();

        $fn($req, $res, $db, $util);
      }
    }

    function post($fn) {

      if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $params = json_decode(file_get_contents('php://input'), true);

        $req = array(
          "params"=> $params
        );
        $res = new Response();
        $db = new Database();
        $util = new Util();

        $fn($req, $res, $db, $util);
      }
    }

    function delete($fn) {

      if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $params = [];
        foreach ($_GET as $key => $value) {
          /** 处理数据类型 */
          if(strstr($key, 'int_')) {
            $params[$key] = intval($value);
          } else if(strstr($key, 'bool_')) {
            if($value === 'true') {
              $params[$key] = true;
            } else {
              $params[$key] = false;
            }
          } else if(strstr($key, 'float_')) {
            $params[$key] = floatval($value);
          }else {
            $params[$key] = $value;
          }
        }

        $req = array(
          "params"=> $params
        );
        $res = new Response();
        $db = new Database();
        $util = new Util();

        $fn($req, $res, $db, $util);
      }
    }

    function put($fn) {

      if($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $params = json_decode(file_get_contents('php://input'), true);
        
        $req = array(
          "params"=> $params
        );
        $res = new Response();
        $db = new Database();
        $util = new Util();

        $fn($req, $res, $db, $util);
      }
    }
  }

  $router = new Router();
?>