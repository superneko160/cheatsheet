# ES2022

## [`Array.prototype.at()`](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Array/at)

インデックスを指定して要素を取得できる

```js
const data = [1, 2, 3];
console.log(data[0]);  // 1
console.log(data.at(0));  // 1
```

本メソッドのうれしいところは、配列の最後の要素の取得が簡単になったこと

```js
const fruits = ['apple', 'grape', 'orange'];
console.log(fruits.at(-1));  // orange
```

それまでは以下のように冗長な記述をしなくてはならなかった

```js
const fruits = ['apple', 'grape', 'orange'];
console.log(fruits[fruits.length - 1]);  // orange
```

文字列版の[`String.prototype.at()`](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/String/at)もこのタイミングで出た

## [`Object.hasOwn()`](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Object/hasOwn)

オブジェクト自身が特定のプロパティを所持しているかどうかを判別するメソッド

もともとは `hasOwnProperty()` を使っていたが、null安全でないなどの問題があった。積極的にこちらを利用していくべき

```js
const user = {
    name: 'Alice',
    email: 'hello@example.com',
};

console.log(Object.hasOwn(user, 'name'));  // true
console.log(Object.hasOwn(user, 'password'));  // false
```
