<?php
namespace Netbeat;

use \Exception;
use \mysqli;

class Ping {
  
  public static function Http($url = "http://www.google.com", $port = 80) {
    if (function_exists("curl_init")) {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_PORT, $port);
      curl_setopt($ch, CURLOPT_NOBODY, true);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_exec($ch);
      $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);    
      return $retcode === 200;
    } else {
      throw new Exception("Ping::Http requires 'curl' extension");
    }
  }

  public static function Ftp($url = "ftp://ftp.mozilla.org", $port = 21) {
    if (function_exists("ftp_connect")) {
      if ($conn = ftp_connect($url, $port)) {
        ftp_close($conn);
        return true;
      } else {
        return false;
      }
    } else {
      throw new Exception("Ping::Ftp requires 'ftp' extension");
    }
  }

  public static function MySQL($host, $user, $password, $port = 3306) {
    if (function_exists("mysqli_connect")) {
      $db = new mysqli($host, $user, $password, "", $port);
      if ($db->connect_error) {
        return false;
      } else {
        $db->close();
        return true;
      }
    } else {
      throw new Exception("Ping::MySQL requires 'mysqli' extension");
    }
  }

  public static function Oracle($user, $password, $host = "localhost:1521/XE") {
    if (function_exists("oci_connect")) {
      $db = oci_connect($user, $password, $host);
      if (!$db) {
        return false;
      } else {
        oci_close($db);
        return true;
      }
    } else {
      throw new Exception("Ping::Oracle requires 'oci8' extension");
    }
  }
  
}