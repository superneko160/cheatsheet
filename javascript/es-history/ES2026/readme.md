#  ES2026

## [JSON.parse()](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/JSON/parse) の引数のコールバック関数の改良

`JSON.parse()` は数値型文字列を数値にするなど、一部の型を勝手に変換してしまい、正確な値が失われてしまうケースがある

```js
const bigNumber = "100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001";
JSON.parse(bigNumber);  // 1e128
```

第2引数に設定するコールバック関数を使えば、変換中の操作への割り込みが可能。これはもともとあった機能。だが、ここで受け取った `val` はすでに変換された後の値

```js
JSON.parse(bigNumber, (key, val) => {
    console.log(val);  // 1e128
    return val;  // 1e128
});
```

この問題が、変換される前の値を第3引数 `context` で受け取れるようになり解決

```js
JSON.parse(bigNumber, (key, val, context) => {
    console.log(context);  // {source:"100000…1"}
    return context.source;  // "100000…1"
});
```
