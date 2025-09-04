# ES2020

## null合体演算子（`??`）

`??` の左辺が `null` または `undefined` の場合のみ、右辺の値を返す演算子

`||` 演算子と混同されやすいが、 `||` がfalsyな値で判定するのに対し、 `??` はnullishな値のみで判定する点が異なる

```js
const count1 = 0 || 10;
const count2 = 0 ?? 10;

console.log(count1);  // 10（0はfalsy）
console.log(count2);  // 0（nullishではない）


const name1 = '' || 'default';
const name2 = '' ?? 'default';

console.log(name1);  // default（空文字はfalsy）
console.log(name2);  // ''（空文字はnullishではない）
```

昔 `||` 演算子しか使えなかった時代でよく悩まされていた「0や空文字が意図せずデフォルト値になってしまう問題」をサクッと解決できるようになった

## オプショナルチェーン（`?.`）

ネストされたオブジェクトの `null` や `undefined` なプロパティのアクセス時に `Cannot read properties of undefined` エラーの発生を抑制し、代わりに `undefined` を返す

```js
const users = [
    { name: 'Jhon', address: { city: 'New York' } },
    { name: 'Mary' },
    { name: 'Sophie', address: { country: 'Singapore' } },
];

// Cannot read properties of undefined...
// for (const user of users) {
//     const city = user.address.city.toUpperCase();
//     console.log(city ?? `No city defined for ${user.name}`);
// }

for (const user of users) {
    // addressからundefinedでもNo Cityと出力できる
    const city = user.address?.city?.toUpperCase();
    // null合体演算子と合わせて利用する
    console.log(city ?? `No city defined for ${user.name}`);
}
```

```js
// メソッドの呼び出しにも使える
const result = obj.method?.();  // methodが存在する場合のみ実行

// 配列へのアクセスにも使える
const firstItem = array?.[0];
```
