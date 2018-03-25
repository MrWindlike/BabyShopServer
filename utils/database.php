<?php
  class Database {
    var $db;

    function connect() {
      $HOSTNAME = "localhost";
      $DATABASE = "BabyShop";
      $USERNAME = "root";
      $PASSWORD = "root";

      $this->db = @mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE) or die(mysqli_error($this->db));
      mysqli_query($this->db,"set names 'utf-8'");
      mysqli_query($this->db,"set character set 'utf8'");
      mysqli_select_db($this->db, $DATABASE) or die(mysqli_error($this->db));
    }

    function close(){
      if ($this->db){
        mysqli_close($this->db) or die(mysqli_error($this->db));
      }
    }

    function select($SQL) {
      $this->connect();
      $results = mysqli_query($this->db, $SQL);
      $list = [];
      $index = 0;

      while ($result = mysqli_fetch_assoc($results)){
        foreach ($result as $key => $value) {
          /** 处理数据类型 */
          if(strstr($key, 'int_')) {
            $list[$index][substr($key, 4)] = intval($value);
          } else if(strstr($key, 'bool_')) {
            $list[$index][substr($key, 5)] = boolval($value);
          } else if(strstr($key, 'float_')) {
            $list[$index][substr($key, 6)] = floatval($value);
          }else {
            $list[$index][$key] = $value;
          }
        }

        $index++;
      }

      $this->close();

      return $list;
    }

    function query($SQL) {
      $this->connect();
      $result = mysqli_query($this->db, $SQL);
      $this->close();

      return $result;
    }

    function insert($table, $params) {
      $this->connect();
      /** 编写SQL插入语句 */
      $SQL = "INSERT INTO $table (";

      foreach ($params as $key => $value) {
        $SQL .= "$key, ";
      }

      $SQL = substr($SQL, 0, strlen($SQL) - 2);
      $SQL .= ") VALUES (";

      foreach ($params as $key => $value) {
        if(is_string($value)) {
          $SQL .= "'$value', ";
        } else if(is_bool($value)) {
          $SQL .= intval($value).", ";
        }else {
          $SQL .= "$value, ";
        }
        
      }

      $SQL = substr($SQL, 0, strlen($SQL) - 2);
      $SQL .= ")";

      /** 插入数据库 */
      $result = mysqli_query($this->db, $SQL);
      $this->close();

      return $result;
    }

    /** 更新 */
    function update($table, $params, $condition) {
      $db->connect();
      $SQL = "UPDATE $table SET ";
      
      foreach ($params as $key => $value) {
        if(is_string($value)) {
          $SQL .= "$key = '$value', ";
        } else if(is_bool($value)) {
          $SQL .= "$key = ".intval($value).", ";
        }else {
          $SQL .= "$key = $value, ";
        }
      }
      $SQL = substr($SQL, 0, strlen($SQL) - 2);
      $SQL .= " $condition";
      // $result = mysqli_query($this->db, $SQL);

      $db-close();

      echo $SQL;
      // return $result;
    }

    /** 删除 */
    function delete($table, $condition) {
      $this->connect();
      $SQL = "DELETE FROM $table $condition";
      $result = mysqli_query($this->db, $SQL);
      $this->close();

      return $result;
    }

    /** 统计 */
    function count($table, $condition) {
      $this->connect();
      $result = mysqli_query($this->db, "SELECT * FROM $table $condition");
      $count = mysqli_num_rows($result);
      $this->close();

      return $count;
    }
  }
?>