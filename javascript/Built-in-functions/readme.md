# JSの組み込み関数

## Index

- [0. プログラミングの関数](#0-プログラミングの関数)
- [1. parseInt()関数](#1-parseInt()関数)
- [2. isNaN()関数](#2-isNaN()関数)

## 0. プログラミングの関数

プログラミングの関数は、以下の2種類に大別されます。

1. ユーザ定義関数
2. 組み込み関数

### 1. ユーザ定義関数

ユーザ定義関数は、開発者自身が作成する関数を指します。  
ここで言うユーザとは、プログラマである私たちです。  
定義する、とは 「つくる」と同じ意味です。  
私たち自身がつくる関数なのでユーザ定義関数です。

### 2. 組み込み関数

プログラミング言語自体が最初から用意してくれている関数です。  
たとえば、Excel等であれば、SUM関数やVLOOKUP関数など、自分たちでつくらずとも、最初から利用できるようになっています。それと同じです。  
プログラミング言語も、自分たちですべてを1から作成するのは大変なので、ある程度、基本的な機能を持った関数を用意してくれています。  
最初から組み込まれている関数なので組み込み関数です。

## 1. [parseInt()関数](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/parseInt)

引数に設定された文字列(`string`型)を数値(`number`型)に変換する関数です。

```js
const n = "10";
console.log(typeof(n));  // string

const result = parseInt(n);
console.log(typeof(result));  // number
```

> [!NOTE]
> `typeof`は型を調べることのできる命令です。
> `typeof`は関数のように思えますが、実際には`+`や`=`といった演算子の仲間です。
> そのため、`typeof`は以下のように記述できます。
> ```js
> console.log(typeof "10");  // string
> ```

## 2. [isNaN()関数](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/isNaN)

引数に設定された値が`NaN（数値ではないことを示す値）`か判定する関数です。  
引数に設定された値が`NaN`（`hello`という文字列など）ならば`true`、`24`などの数値ならば`false`を返します。

```js
const input = window.prompt('数値を入力してください');

if (isNaN(input)) {
    window.alert('入力された値は数値ではありません');
}
```
