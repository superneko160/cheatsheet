<?php
use PHPUnit\Framework\TestCase;

require_once 'Mathmatic.php';

/**
 * テストコード
 */
class MathmaticTest extends TestCase {

  /**
   * add関数をテストするためのメソッド
   * 命名：testXXXXX
   */
  public function testAdd() {

    // assertEquals(期待される値, テスト対象)
    $this->assertEquals(3, Mathmatic::add(1, 2));
  }
}
