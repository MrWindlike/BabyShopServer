<?php
  class Response {
    function send($code, $msg, $data = []) {
      $res = array(
        "code"=> $code,
        "msg"=> $msg,
        "data"=> $data
      );

      echo json_encode($res);
    }
  }
?>