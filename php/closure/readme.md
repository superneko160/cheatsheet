# クロージャ

無名関数のこと

## 無名関数を変数に代入する手法

```php
// 関数の定義
$addPlusOne = function($number) {
    return $number + 1;
};

// 関数の呼び出し
print $addPlusOne(10); // 11
```

## `use`

クロージャで `use` を利用すると、親スコープの変数をキャプチャ（コピー）できる

```php
$prefix = 'Name: ';

// 関数の定義
$addPrefix = function($name) use ($prefix) {
    return $prefix . $name;
};

// 関数の呼び出し
print $addPrefix('Alice'); // Name: Alice
```

とくにコールバック関数と相性がいい

```php
$animals = ['dog', 'cat', 'rabbit', 'fox', 'shark', 'elephant'];
$max_char = 5;

$result = array_filter($animals, function($animal) use ($max_char) {
    return mb_strlen($animal) >= $max_char;
});

var_dump($result); // ['rabbit', 'shark', 'elephant']
```
