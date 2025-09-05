# ES2023

非破壊的メソッドが大量に導入された。正直今までなかったのが不思議なレベル

```js
// 既存の配列操作メソッドは、変更後の値を返すと同時に元の値も変更してしまう

const a = [2, 3, 1];

const b = a;
b[1] = 4;
console.table(b);  // [2, 4, 1]
console.table(a);  // [2, 4, 1] ← ？

const c = a.sort();
console.table(c);  // [1, 2, 4]
console.table(a);  // [1, 2, 4] ← ？？

const d = a.reverse();
console.table(d);  // [4, 2, 1]
console.table(a);  // [4, 2, 1] ← ？？？
```

## [`Array.prototype.with()`](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Array/with)

普段から利用している方法（ `array[index] = value` ）は破壊的だが、`with(index, value)` を利用した方法は非破壊的である。また、チェーンできるので `map()` や `filter()` と相性が良い

```js
const data = [2, 7, 11];
const result = data.with(1, 100);
console.log(result);  // [2, 100, 11];
```

## [`Array.prototype.toSorted()`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/toSorted)

`sort()` の非破壊的ver

```js
const unsortedNumbers = [3, 1, 2];
const sortedNumbers = unsortedNumbers.toSorted();
console.log(sortedNumbers);    // [1, 2, 3](新しい配列)
console.log(unsortedNumbers);  // [3, 1, 2](元のまま)
```

## [`Array.prototype.toReversed()`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/toReversed)

`reversed()` の非破壊的ver

```js
const numbers = [1, 2, 3];
const reversedNumbers = numbers.toReversed();
console.log(reversedNumbers);  // [3, 2, 1](新しい配列)
console.log(numbers);          // [1, 2, 3](元のまま)
```
