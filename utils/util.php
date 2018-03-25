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
  }
?>