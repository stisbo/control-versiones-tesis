<?php

namespace App\Config;

class Database {
  private static $con = null;
  private function __construct() {
  }
  public static function getInstace() {
    if (empty(self::$con)) {
      $serverName = "localhost";
      $databaseName = "tesis";
      $username = "sa2";
      $password = "";
      try {
        self::$con = new \PDO("sqlsrv:Server=$serverName;Database=$databaseName;Encrypt=0;TrustServerCertificate=1", $username, $password);
        self::$con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      } catch (\PDOException $e) {
        self::$con = null;
        die("Error de conexión: " . $e->getMessage());
      }
    }
    return self::$con;
  }
}
