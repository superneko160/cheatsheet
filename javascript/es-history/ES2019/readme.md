# ES2019

## [`Object.fromEntries()`](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Object/fromEntries)

`Object.entries()` などで配列化したオブジェクトを、再びオブジェクトに戻すときに便利なメソッド。配列のメソッドでフィルタリングや変換を行った後、最後にオブジェクトに戻すという処理が簡潔に記述できるようになった

```js
const data = [
    ['name', 'Alice'],
    ['email', 'hello@example.com'],
];

const user = Object.fromEntries(data);
console.log(user);  // { name: 'Alice', email: 'hello@example.com' }
```
