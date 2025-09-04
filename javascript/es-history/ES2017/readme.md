# ES2017

これまで [`Object.keys()`](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Object/keys) などでキーを取得してから値にアクセスしていた処理が格段にシンプルにかけるようになった。特に `Object.entries()` は、オブジェクトを配列のメソッド（map、filter、reduceなど）で処理したいときに威力を発揮する

## [`Object.values()`](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Object/values)

オブジェクトから値のみ抽出した配列を取得

```js
const scores = {
    math: 80,
    english: 75,
    science: 92,
};

const values = Object.values(scores);
console.log(values);  // [ 80, 75, 92 ]
```

## [`Object.entries()`](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Object/entries)

キーと値のペアを配列で取得する

```js
const scores = {
    math: 80,
    english: 75,
    science: 92,
};

const entries = Object.entries(scores);
console.log(entries);  // [ [ 'math', 80 ], [ 'english', 75 ], [ 'science', 92 ] ]
```
