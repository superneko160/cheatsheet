<?php
// 乗り物クラス
class Vehicle {

    private float $speed = 0;  // 速度

    /**
     * 加速する
     * @param float $amount 加速量
     * @return float 加速後の速度
     */
    public function acceleration(float $amount): float {
        $this->speed += $amount;
        return $this->speed;
    }

    /**
     * 減速する
     * @param float $amount 減速量
     * @return float 減速後の速度
     */
    public function brake(float $amount): float {
        $this->speed -= $amount;
        return $this->speed;
    }

    /**
     * クラクションを鳴らす
     */
    public function horn(): void {
        // クラクションを鳴らす処理...
    }
}

// 自動車クラス
class Car extends Vehicle {
    /**
     * 継承しているので
     * 加速メソッドと減速メソッドを
     * 書かなくても使える
     */

    // 自動車特有の処理があれば追加...
}

// 自転車クラス
class Bicycle extends Vehicle {
    /**
     * 継承しているので
     * 加速メソッドと減速メソッドを
     * 書かなくても使える
     */

    // 自転車特有の処理があれば追加...

    // 問題点
    // horn()メソッドは不要なのに使えていまう！
}

/* === メイン処理 === */
$car = new Car();
$car->horn();  // 車がクラクションを鳴らす

$bicycle = new Bicycle();
$bicycle->horn();  //自転車がクラクションを鳴らす？

/**
 * ■継承の問題点
 * 1. 親クラスの変更の影響を子クラスが受けやすい
 * 2. 不必要なプロパティやメソッドまで継承できてしまう
 * Q. 使わなければいいだけではないか？
 * A. ほかの開発者は「使える」＝「どんな使い方をしてもよい」と考えてしまう
 * 　　=>「安全」という考え方から遠ざかってしまう
 */
