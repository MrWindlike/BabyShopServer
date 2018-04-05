<?php
  class Util {
    /** 检查$array[$key]是否存在且不为空字符串 */
    function isSetParams($array, $keys) {
      $flag = true;
      $lostKey = '';

      foreach ($keys as $i => $key) {
        if(isset($array[$key]) === false || $array[$key] === '') {
          $flag = false;
          $lostKey = $key;
          break;
        }
      }

      return array("flag"=> $flag, "key"=> $lostKey);
    }

    /** 检查手机格式是否正确 */
    function checkPhone($phone) {
      return preg_match("/^[1][3,4,5,7,8][0-9]{9}$/", $phone);
    }

    /** 获取当前毫秒数 */
    function getMs() {
      list($msec, $sec) = explode(' ', microtime());
      $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);

      return $msectime;
    }

    /** 检查是否登陆 */
    function checkAuthorization($db) {
      $token = getallheaders()['Token'];
      
      $result = $db->select("SELECT int_id, username, float_time FROM admin WHERE token = '$token'");

      if($result && $this->getMs() <= $result[0]['time'] + 86400000) {
        return $result[0];
      } else {
        return false;
      }
    }
  }
?>