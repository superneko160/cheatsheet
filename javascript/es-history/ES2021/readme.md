# ES2021

## [`String.prototype.replaceAll()`](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/String/replaceAll)


引数にマッチした文字列をすべて置換できるメソッド。このメソッドが出てくるまでは正規表現オプション `g` を付与して解決していた

```js
'私は犬が好きだ。犬はすごい生きものだ'.replace(/犬/g, '猫');  // '私は猫が好きだ。猫はすごい生きものだ'
```

同じ系統の[`String.prototype.matchAll()`](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/String/matchAll) も同様にES2021から登場した

## 大きな数値が `_` 区切りで記述可能に

可読性向上のための記述方法

```js
const num = 100_000_000;  // 1億（100,000,000）
```
