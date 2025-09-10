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
}

// クラクションを鳴らすクラス
class HornBehavior {
    /**
     * クラクションを鳴らす
     */
    public function horn(): void {
        // クラクションを鳴らす処理...
    }
}

// 自動車クラス
class Car extends Vehicle {

    private HornBehavior $hornBehavior;

    public function __construct() {
        $this->hornBehavior = new HornBehavior();
    }

    public function hornCar() {
        /**
         * 移譲
         * ほかのクラスに処理を委ねる
         */
        $this->hornBehavior->horn();
    }
}

// 自転車クラス
class Bicycle extends Vehicle {
    /**
     * Vehicleクラスにはhorn()メソッドはないので
     * 当然、Bicycleクラスはhorn()メソッドを使えない
     * （単に継承してないだけ）
     */
}

/* === メイン処理 === */
$car = new Car();
$car->hornCar();  // 車がクラクションを鳴らす

$bicycle = new Bicycle();
$bicycle->hornCar();  // error

/**
 * ■委譲（delegation）
 * 利用したい機能を持つクラス（オブジェクト）を
 * 現在のクラスのプロパティとして取り込んだり
 * メソッドのなかでインスタンス化して使う
 * 
 * 委譲の利用で継承の問題点を回避できる
 * 1. 不必要なプロパティ・メソッドを無効化せずに済む
 * 2. クラス同士の関係性が緩まる（結合度が下がる）
 */
