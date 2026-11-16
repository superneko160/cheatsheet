# PHP8.5

## パイプライン演算子

新機能の白眉。データの流れがわかりやすくなる

```php
'Hello'
    |> strtoupper(...)              // 大文字に変換
    |> str_split(...)               // 1文字ずつ分割して配列に格納
    |> (fn($chars) => array_filter( // O以外の文字を抽出
        $chars,
        fn ($char) => $char !== 'O'
    ))
    |> (fn($chars) => array_walk(   // 1文字ずつ改行しつつ表示
        $chars,
        fn ($char, $index, $prefix) => print $char . $prefix,
        '<br>'
    ));

// 結果
// H
// E
// L
// L
```

- パイプライン演算子は左辺の値を右辺の呼び出し可能なものに1引数で渡すため、 `array_filter` などはアロー関数などでラップする必要あり
- PHP8.6から部分適用（Haskellなどに備わっている）がくるため、それと組み合わせるとより簡単に書ける

## 配列の最初と末尾の要素を取得するメソッド

正直、今更感がある

```php
$animals = ['dog', 'cat', 'fox'];
print array_first($animals); // dog
print array_last($animals);  // fox
```

## NoDiscard属性

NoDiscard属性を付与すると、必ず変数で返り値を受け取らないといけないようにできる

```php
#[\NoDiscard]
function hoge(): int {
    return 1;
}

// hoge(); // error
$result = hoge(); // ok
```
