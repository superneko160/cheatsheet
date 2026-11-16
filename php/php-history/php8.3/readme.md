# PHP8.3

## クラス定数に型宣言が追加可能になった

今までできなかったんですか？

```php
class UrlValidator {
    const string URL = '';
}
```

## [mt_str_pad()](https://www.php.net/manual/ja/function.mb-str-pad.php)

`str_pad()` のマルチバイト版

```php
$str = '名';
echo mb_str_pad($str, 3, '■');
echo  '<br>';
```

## [json_validate()](https://www.php.net/manual/ja/function.json-validate.php)

有効なJSONか判定するだけ。でも便利

```php
var_dump(json_validate('{ "test": { "foo": "bar" } }')); // true
```
