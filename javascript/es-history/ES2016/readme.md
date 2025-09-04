# ES2016

## [`Array.prototype.includes()`](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Array/includes)

配列に特定の要素が含まれているか判定するメソッド。ループして1つ1つ判定するのを避けられる

```js
const numbers = [1, 2, 3];
console.log(numbers.includes(2));  // true
console.log(numbers.includes(4));  // false
```
