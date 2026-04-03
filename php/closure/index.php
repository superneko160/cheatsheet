<?php
/**
 * クロージャ（無名関数）
 * クロージャでは use を利用し、親スコープの変数のキャプチャ（コピー）が可能
 */

// 親スコープ（関数外）の変数
$add_number = 1;

// useを利用したver
$calc = function($number) use ($add_number) {
    $add_number++; // 2
    return $number + $add_number; // 10 + 2
};

// globalを利用したver
// $calc = function($number) {
//     global $add_number;
//     $add_number++;
//     return $number + $add_number;
// };

print $calc(10); // 12
print "<br>";

// useを利用した場合は1
// globalを利用した場合は2
// このことからuseを利用した場合、親スコープの変数を参照ではなくコピーしているとわかる
print $add_number;
