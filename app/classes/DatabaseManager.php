<?php
class DatabaseManager {
  public static function connect (){
    try {
      $pdo = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (PDOException $ex) {
      throw new Exception('PDOError! ' . $ex->getMessage());
    }
  }
}