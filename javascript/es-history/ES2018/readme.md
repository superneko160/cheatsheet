# ES2018

## オブジェクトに対する Rest / Spread 構文

ES6から配列に対しては使えていた Rest / Spread 構文（`...`）がオブジェクトでも利用可能になった

```js
const user = {
    name: 'Alice',
    email: 'hello@example.com',
};

// Spread: オブジェクトの展開
const updatedUser = { ...user, email: 'change@example.com' };

console.log(updatedUser);  // { name: 'Alice', email: 'change@example.com' }
```

```js
const user = {
    name: 'Alice',
    email: 'hello@example.com',
    password: 'abcdefghijklmn0123456789',
};

// Rest: プロパティをまとめる
const { password, ...publicUserData } = user;

console.log(publicUserData); // {name: 'Alice', email: 'hello@example.com'}
console.log(password);  // abcdefghijklmn0123456789
```

構文が、左辺にあればRest、右辺にあればSpread
