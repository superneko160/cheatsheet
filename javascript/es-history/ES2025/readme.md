#  ES2025

## [`Promise.try()`](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Promise/try)

あらゆる種類のコールバックを受け取り、その結果を `Promise` でラップして返す

同期かもしれないし非同期かもしれない、Promiseを返す返さないかどっちかわからない関数があるとする。この場合、同期、非同期の処理を区別して記述すると複雑になるため、一括して表現したい。

```js
// 非同期関数
function funcAsync() {
    return new Promise((resolve, reject) => {
        resolve('foo!');
    });
}

// 同期関数
function funcSync() {
    return 'bar!';
}

funcAsync().then(); // ok
funcSync().then(); // error
```

`Promise.try` を利用せずに記述する方法もある

```js
console.log(Promise.resolve().then(funcAsync));
console.log(Promise.resolve().then(funcSync));
```

ただし、上の書き方だと遅くなるらしい。遅延なく実行させたい場合、以下のように書く必要がある

```js
console.log(new Promise(resolve => resolve(funcAsync())));
console.log(new Promise(resolve => resolve(funcSync())));
```

ES2025から登場した `Promise.try` を使えば簡潔に表現できる

```js
console.log(Promise.try(funcAsync));
console.log(Promise.try(funcSync));
```

### 実用的な例

```js
// この関数の結果は同期かもしれないし非同期かもしれない
function getUser(id) {
    if (cache.has(id)) return cache.get(id); // 同期
    return fetch(`/api/users/${id}`).then(r => r.json()); // 非同期
}

// Promise.try で統一した書き方が可能に
Promise.try(() => getUser(userId))
    .then(user => render(user))
    .catch(err => showError(err));
```
