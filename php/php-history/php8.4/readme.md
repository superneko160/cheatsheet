# PHP8.4

## [mb_trim()](https://www.php.net/manual/ja/function.mb-trim.php)


`trim()` のマルチバイト版。これで先頭と末尾の全角スペースもカットできる。これが出てくるまでは `str_replace()` で頑張っていた。かなり嬉しい

```php
var_dump(mb_trim('　あ　')); // string(3) "あ"
```

## 配列検索系の関数4つ追加

```php
// 検索対象
$data = [
    'a' => 'dog',
    'b' => 'cat',
    'c' => 'cow',
    'd' => 'duck',
    'e' => 'goose',
    'f' => 'elephant'
];
```

### [array_find()](https://www.php.net/manual/ja/function.array-find.php)

検索して最初の値を返す

```php
var_dump(
    array_find($data, fn (string $value) => strlen($value) > 4)
);  // goose
```

### [array_find_key()](https://www.php.net/manual/ja/function.array-find-key.php)

検索して最初のキーを返す

```php
var_dump(
    array_find_key($data, fn (string $value, $key) => preg_match('/^([b-f])$/', $key))
);  // b
```

### [array_any()](https://www.php.net/manual/ja/function.array-any.php)

ひとつでも `true` であれば `true`

```php
var_dump(
    array_any($data, fn (string $value) => strlen($value) < 3)
);  // false
```

### [array_all()](https://www.php.net/manual/ja/function.array-all.php)

全項目が `true` であれば `true`

```php
var_dump(
    array_all($data, fn (string $value, $key) => is_string($key))
);  // true
```
