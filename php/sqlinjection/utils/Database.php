<?php
require_once 'CodeInfo.php';
/**
 * データベース管理クラス
 */
class Database {

  /**
   * DBの取得
   * @return PDO|null $db データベース
   */
  public static function getDb(): ?PDO {
    try {
      $codes = CodeInfo::getCodes();
      $db = new PDO($codes["dns"], $codes["db_user"], $codes["db_password"]);
      return $db;
    }
    catch (PDOException $e) {
      print "接続エラー：{$e->getMessage()}";
      return null;
    }
  }
}
