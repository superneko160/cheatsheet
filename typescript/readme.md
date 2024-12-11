# TypeScriptチートシート

## Index

- [0. 想定読者](#0-想定読者)
- [1. TypeScriptとは](#1-typescriptとは)
- [2. 型注釈](#2-型注釈)
- [3. 型推論](#3-型推論)
- [4. 基本の型](#4-基本の型)
- [5. 特殊な型](#5-特殊な型)
- [6. 型エイリアス](#6-型エイリアス)
- [7. 型アサーション](#7-型アサーション)
- [8. 配列の型注釈](#8-配列の型注釈)
- [9. タプル型](#9-タプル型)
- [10. オブジェクトの型注釈](#10-オブジェクトの型注釈)
- [11. オプションプロパティ](#11-オプションプロパティ)
- [12. インデックス型](#12-インデックス型)
- [13. オプショナルチェーン](#13-オプショナルチェーン)
- [14. Mapオブジェクト](#14-mapオブジェクト)
- [15. Setオブジェクト](#15-setオブジェクト)
- [16. 列挙型（Enum）](#16-列挙型enum)
- [17. インターセクション型](#17-インターセクション型)
- [18. 分割代入](#18-分割代入)
- [19. オプション引数](#19-オプション引数)
- [20. 型ガード関数](#20-型ガード関数)
- [21. ジェネリクス](#21-ジェネリクス)
- [22. Widening（型の拡大）](#22-widening型の拡大)
- [23. 参考](#23-参考)

## 0. 想定読者

- 基本的なWebの仕様を理解している
- 基礎的なJavaScriptを記述できる

`node.js`などをインストールし、ローカル環境で実行するのもよいが、もし、コマンドライン等の知識がなければ[Playground](https://www.typescriptlang.org/play/)で試すのが手っ取り早い

## 1. TypeScriptとは

- JavaScript（以下JS）のスーパーセットとなるプログラミング言語
- スーパーセットとは、ここでは、元の言語との互換性を保ちつつ、元の言語を拡張して作った言語のことを指す
- TypeScript（以下TS）は、JSとの互換性を保ちつつ、JSを拡張して作った言語である。よって、JSのコードはすべてTSとして扱える
- TSは、型注釈やインターフェース、ジェネリクスなど独自の機能を追加している

## 2. 型注釈

- 変数にどのような値が代入できるのかを制約するものを「型」と呼ぶ
- 開発者は、変数がどのような型なのかを型注釈で指定する

## 3. 型推論

- 値の型が文脈で明白な場合、型が自動で判断される。この仕組みを型推論と呼ぶ
- 型推論のおかげで、開発者は型注釈を割愛でき、記述量を減らせる

## 4. 基本の型

`boolean`、`number`、`bigint`、`string`、`undefined`、`null`、`Symbol`

### Symbol型

一意なる値を作成する型

```ts
const s1 = Symbol('foo')
const s2 = Symbol('foo')

console.log(s1 === s1)  // true
console.log(s1 === s2)  // false
```

## 5. 特殊な型

`any`、`unknown`、`void`、`never`

- `void`：値が存在しない、関数がなにも返さないとき利用
- `never`：エラーを投げる、無限ループの関数などで利用

## 6. 型エイリアス

既存の型を新たな名前で定義する機能

```ts
type StringOrNumber = string | number
const str: StringOrNumber = 'hello'
const num: StringOrNumber = 24
```

## 7. 型アサーション

特定の変数や式の型を明示的に指定する方法。コンパイラに対して「この変数は特定の型であると信頼してください」というメッセージを送るようなイメージ

```ts
変数 = 値 as 型
```

TypeScriptが具体的な型を知ることができないケースがある。たとえば、`document.getElementById`を利用する場合、TypeScriptは`HTMLElement`（か`null`）が返ってくるということしかわからない

`HTMLElement`でも、それが`input`なのか`canvas`なのかでできる操作は異なる。ただ、TS上では`document.getElementById()`で取得できるものの型が判別できないので、`input`の場合は～、`canvas`の場合は～、と自動で判定できない

次のコードはJSではエラーにならないが、TSではコンパイル時にエラーになる。なぜなら`getElementById()`が返すのは`HTMLElement`型であり、`HTMLCanvasElement`型ではないから

```ts
const canvas = document.getElementById('canvas')
console.log(canvas.width)  // error
```

以下のように型アサーションを利用し、コンパイルできる

```ts
const canvas = document.getElementById('canvas') as HTMLCanvasElement
```

### as const

`as const`は変数、配列、オブジェクトに使うことができる特別な型アサーション

通常、オブジェクトや配列を定義すると、そのプロパティや要素は変更可能（mutable）と見なされる  
しかし、`as const`を使うことで、それらが変更不可能（immutable）なものとして扱われ、さらに型がより厳密に推論されるようになる

#### as constの注意点

`as const`はリテラル値やリテラルからなるオブジェクト、配列に対して適用可能。しかし、**演算結果や関数の戻り値など、リテラル以外の式には使えない**

```ts
let num = 25 as const;  // OK（25のリテラル型になる）
let result = (12 + 3) as const  // error
let age = getNum() as const  // error

function getNum(): number {
  return 15
}
```

#### 具体例1. enumの代わりにas constを利用

`enum`は特定の選択肢のセットを簡単に扱うことができる。以下は方向を表す`enum`

```ts
enum Direction {
  Up, Down, Left, Right
}
```

上の`enum`は`Direction.Up`のように使うことができるほか、`Direction[0]`としてインデックスで逆引きすることも可能

しかし、この逆引きには落とし穴がある。**存在しないインデックスを指定すると`undefined`が返ることである**

```ts
console.log(Direction[0])  // "Up"
console.log(Direction[4])  // undefined
```

以下は`as const`を使った代替案

```ts
const Directions = {
  Up: 0,
  Down: 1,
  Left: 2,
  Right: 3
} as const
```

このように書くと、`Directions.Up`のようにして値を参照することはできるが、`Directions[0]`のようにインデックスでアクセスすることはできなくなる。このようにして`undefined`を返すリスクを回避できる

#### 具体例2. as constを使ってUnion型を作成

Union型は、変数が取り得る型が複数ある場合に使う型である。ある変数が文字列の「Hello」または「Goodbye」のみを取り得るとき、その変数の型は`'Hello' | 'Goodbye'`と表現できる。しかし、これらの値が多くなると、手動でUnion型を定義するのは大変である

そこでas constを使う。オブジェクトのプロパティや配列の要素にas constを適用することで、TypeScriptによる型推論を利用して、自動的に正確なUnion型を得ることができる

```ts
const responseStates = ["loading", "success", "error"] as const
// type ResponseState = "loading" | "success" | "error"
type ResponseState = (typeof responseStates)[number]
```

## 8. 配列の型注釈

```ts
const numbers: number[] = [1, 2, 3]
```

### 読み取り専用の配列

`readonly`を利用

```ts
const numbers: readonly number[] = [1, 2, 3]
numbers[0] = 4  // error
```

## 9. タプル型

以下の特徴を持つ

- 配列の要素数と要素の型が固定
- それぞれの要素のインデックスごとに型が決まる

```ts
const tuple: [string, number] = ['hello', 10]
console.log(tuple[0])  // hello（アクセスの仕方は配列と同じ）
```

```ts
const tuple: [string, number] = [10, 'hello']  // error
```

## 10. オブジェクトの型注釈

```ts
const obj: { name: string; age: number }
```

### 読み取り専用のオブジェクト

配列と同じく`readonly`を利用

```ts
let obj: { readonly name: string; age: number }
obj = { name: "John", age: 20 }
obj.name = "Tom"  // error
```

## 11. オプションプロパティ

`?`を付与したプロパティは省略可能になる

```ts
let obj: { name: string; age?: number }
obj = { name: "John" }  // `age`プロパティがなくてもエラーにならない
```

## 12. インデックス型

インデックス型プロパティの型注釈は`[キー名: プロパティキーの型]: プロパティ値の型`の形で記述

```ts
let obj: { [key: string]: number }
obj = { key1: 1, key2: 2 }
console.log(obj["key1"])
console.log(obj["key2"])
```

## 13. オプショナルチェーン

プロパティが存在するかどうか不確定である場合、`?.`演算子で安全にアクセス可能

```ts
function printLength(obj: { str?: string }) {
  console.log(obj.str?.length)
}
printLength({ str: "hello" })  // 5
printLength({})  // undefined
```

## 14. Mapオブジェクト

- Mapオブジェクトはキーとそれに対応する値を対にしたコレクション
- キーはオブジェクトも含め任意の値が可能

```ts
const people = new Map()
map.set("name", "John")
map.set("age", "20")
 
console.log(map.get("name"))  // Jhon
```

Mapの型注釈は`Map<キーの型, 値の型>`の形で記述

```ts
const people: Map<string, number>
```

### Mapのループ

- Mapオブジェクトは`for...of`でループすると、各エントリーがキーと値の配列として順に取得できる
- 要素の順序は、要素を追加した順が保証されている

```ts
for (const [key, value] of map) {
  console.log(key, value)
}
```

## 15. Setオブジェクト

- Setオブジェクトは同じ値が存在しないコレクション
- Setの要素は何でも可能

```ts
const set = new Set()
set.add(1)
set.add(2)
set.add(2) // 同じ値は追加されない。

console.log(set)
```

Setの型注釈は`Set<要素の型>`の形で記述

```ts
let numSet: Set<number>
```

### Setのループ

- SetもMap同様にfor...ofでループすることが可能
- 順序はaddした順

```ts
for (const value of set) {
  console.log(value)
}
```

## 16. 列挙型（Enum）

関連する一連の数値または文字列値の集まりを定義

```ts
enum Color {
    Red,
    Green,
    Blue,
}
```

列挙体の値は文字列リテラルまたは数値リテラルで指定できる

```ts
enum Color {
  Red = "red",
  Green = "green",
  Blue = "blue",
}
```

列挙型の各値にアクセスするにはドット演算子を使用

```ts
const myColor: Color = Color.Red
```

## 17. インターセクション型

複数の型を1つに結合した新しい型を定義。`型1 & 型2 & ...`の形式で使う。その結果として生じた型は、それぞれの型が持つすべてのプロパティとメソッドを備えている

```ts
type Octopus = { swims: boolean }
type Cat = { nightVision: boolean }
type Octocat = Octopus & Cat

const octocat: Octocat = { swims: true, nightVision: true }
console.log(octocat)  // { swims: true, nightVision: true }
```

### インターセクション型の注意点

同じプロパティ名で異なる型を持つ型を組み合わせてしまう可能性がある。もし、同じプロパティ名だった場合、`never`型になる（どんな値も代入できない型）

```ts
// AにもBにもxプロパティがある
type A = { x: number }
type B = { x: string }
type C = A & B

// xはnever型になっているので代入できずエラー
const c: C = { x: 1 }
```

### 具体例1. 複数のインターフェースを組み合わせた新しい型の作成

```ts
interface Name {
  name: string
}

interface Age {
  age: number
}

interface Address {
  address: string
}

type Employee = Name & Age & Address

const john: Employee = {
  name: 'Jhon Doe',
  age: 31,
  address: '123 Main St'
}
```

### 具体例2. オプショナルプロパティの追加

```ts
type BasicPerson = {
  name: string
  age: number
}

type PersonWithJob = BasicPerson & {
  job?: string
}

const alice: PersonWithJob = {
  name: 'Alice',
  age: 24
}

const bob: PersonWithJob = {
  name: 'Bob',
  age: 32,
  job: 'Developer'
}
```

### 具体例3. 既存の型の拡張（2とほぼ同じ）

```ts
type OriginalType = {
  id: number
  name: string
}

type ExtendType = OriginalType & {
  description: string
  createdAt: Date
}

const item: ExtendedType = {
  id: 1,
  name: 'Item 1',
  description: 'This is item 1',
  createdAt: new Date()
}
```

## 18. 分割代入

### 配列の分割代入

```ts
const [a, b] = [1, 2]
console.log(a)  // 1
console.log(b)  // 2
```

### オブジェクトの分割代入

```ts
const obj = {
  name: "John",
  age: 20,
}
 
const { name, age } = obj
console.log(name)  // Jhon
console.log(age)  // 20
```

### 分割代入引数

関数の引数に配列またはオブジェクトリテラルを展開する

```ts
const printCoord = ({ x, y }: { x: number; y: number }) => {
  console.log(`Coordinate is (${x}, ${y})`)
};
 
printCoord({ x: 10, y: 20 })  // 'Coordinate is (10, 20)'
```

## 19. オプション引数

関数の引数に`?`を付与し、任意とすることが可能

```ts
function greet(name?: string) {
  if (name === undefined) {
    return "Hello!"
  } else {
    return `Hello ${name}!`
  }
}
 
console.log(greet("John"))  // Jhon
console.log(greet())  // Hello!
```

## 20. 型ガード関数

型ガードとは、ある値に対して特定の型かどうかチェックし、その結果に応じて処理を分けること

つまり、型ガード関数とは、特定の型であることを判定する関数。型の絞り込みができる

```ts
// string型であることを絞り込む型ガード関数
function isString(value: any): value is string {
    // string型の場合、trueを返す
    return typeof value === 'string'
}

// 内部で型ガード関数を利用している関数
function printLength(value: any) {
    if (isString(value)) {
        // この節ではvalueはstring型として扱われる
        console.log(value.length);
    }
}

printLength('hello')  // 5
```

### typeof型演算子

`typeof`は変数名から型を逆算する

```ts
const obj = {
    name: 'TypeScript',
    version: 3.9
}

type ObjectType = typeof object
```

### 型ガード例

外部APIからデータを受け取ったとする例

```ts
interface AdminUser {
    id: number
    username: string
    admin: true
}

interface NormalUser {
    id: number
    username: string
    admin: false
}

type User = AdminUser | NormalUser

function isAdmin(user: User): user is AdminUser {
    return user.admin
}

// 外部APIから取得したユーザデータ
const userFromApi: User[] = [
    { id: 1, username: 'adminUser', admin:true },
    { id: 2, username: 'normalUser', admin:false },
]

userFromApi.forEach(user => {
    if (isAdmin(user)) {
        console.log(`${user.username} is an admin.`)
    } else {
         console.log(`${user.username} is not an admin.`)
    }
})
```

## 21. ジェネリクス

`T`の部分を**型変数**と呼ぶ。型変数は、言葉の通り、型を代入できる変数

```ts
// Tが型変数
function identity<T>(arg: T): T {
    return arg
}

// 型変数Tにstringを割り当てる
// const output1: string
const output1 = identity<string>('hello')

// 型変数Tにnumberを割り当てる
// const output2: number
const output2 = identity<number>(100)
```

型変数には、一般的には`T`と`U`が用いられる

```ts
function compare<T, U>(a: T, b: U) {}
```

## 22. Widening（型の拡大）

Wideningはある変数に割り当てられた狭い型が、より広い型に変わる現象

### 1. 代入での型の拡大

```ts
// "hoge"というリテラル型で推論される
const hoge = "hoge"
```

`hoge`はリテラル型`"hoge"`と推論される。しかし、`let`を利用すると、同じ値を持っていても、その型はもっと広い`string`型として推論される

```ts
// string型で推論される
let hoge = "hoge"
```

ここでの`hoge`は、どんな文字列も受け入れる`string`型とみなされる

さらに、`const`で宣言した変数を`let`で宣言した変数に代入するというケースも見てみる。この場合も、`string`型に広がってWideningが起こる

```ts
// "hoge"というリテラル型で推論される
const hogeLiteral = "hoge"
// string型で推論される
let hogeString = hogeLiteral
```

### 2. オブジェクトでの型の拡大

オブジェクトのプロパティとして`const`で宣言した値を設定すると、そのプロパティの型が拡大される

```ts
// "hoge"というリテラル型で推論される
const hoge = "hoge"

const obj = {
  hoge,
}
// string型で推論されるので代入できてしまう
obj.hoge = "fuga"
```

`obj.hoge`は最初`"hoge"`のリテラル型であったにもかかわらず、`string`型として扱われ、異なる文字列`"fuga"`を代入できてしまった

### 防ぎ方

`as const`を使う

```ts
const message = "Hello, TypeScript" as const
```

`message`は単なる文字列ではなく、文字列リテラル`"Hello, TypeScript"`として扱われる。このおかげで、`message`に`"Hello, TypeScript"`以外の何かを代入しようとすると、TypeScriptから警告されるようになる

オブジェクトも同様

```ts
const userInfo = {
  name: "Jane",
  age: 33,
} as const
```

## 23. 参考

- [TypeScript入門『サバイバルTypeScript』](https://typescriptbook.jp/)
