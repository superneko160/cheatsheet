# TypeScriptチートシート

## 0. 想定読者

- 基本的なWebの仕様を理解している
- 基礎的なJavaScriptを記述できる

`node.js`などをインストールし、ローカル環境で実行するのもよいが、もし、コマンドライン等の知識がなければ[Playground](https://www.typescriptlang.org/play/)で試すのが手っ取り早い

> [!NOTE]
> このチートシートは、TSでのみ利用できる機能だけではなく、オプショナルチェーンなど、JSで利用できる機能も記述している

## 1. TypeScriptとは

- JavaScript（以下JS）のスーパーセットとなるプログラミング言語
- スーパーセットとは、ここでは、元の言語との互換性を保ちつつ、元の言語を拡張して作った言語のことを指す
- TypeScript（以下TS）は、JSとの互換性を保ちつつ、JSを拡張して作った言語である。よって、JSのコードはすべてTSとして扱える
- TSは、型注釈やインターフェース、ジェネリクスなど独自の機能を追加している

## 2. 型注釈

- 変数にどのような値が代入できるのかを制約するものを「型」と呼ぶ
- 開発者は、変数がどのような型なのかを型注釈で指定する
- 型注釈は型アノテーションとも呼ばれる

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

### 関数の返り値として別の関数を返す場合の型

以下のようにして、関数を返す関数（高階関数）の型安全性を確保できる

関数の返り値として別の関数を返す場合、その型は `(引数の型) => (返り値の関数の型)`のように定義する

```ts
// 数値を受け取り、その数を掛け算する関数を返す関数
type MultiplyFunction = (x: number) => number         // 数値を受け取って数値を返す関数の型
type GetMultiplier = (n: number) => MultiplyFunction  // 数値を受け取り、MultiplyFunctionを返す関数の型

const getMultiplier: GetMultiplier = (n) => {
  return (x) => n * x;  // GetMultiplier型の関数を返す
}

const double = getMultiplier(2)  // 2を掛ける関数を取得
const triple = getMultiplier(3)  // 3を掛ける関数を取得

console.log(double(5))  // 10
console.log(triple(5))  // 15
```

## 5. 特殊な型

`any`、`unknown`、`void`、`never`

- `any`: なんでもいい型
- `unknwon`: なんでもいい型（オブジェクトの操作はできない）
- `void`: 値が存在しない、関数がなにも返さないとき利用
- `never`: エラーを投げる、無限ループの関数などで利用

### any型とunknown型の違い

`any`型と違い`unknown`型はオブジェクトの操作ができない

```ts
const anyObj: any = {
  id: 'A001',
  name: 'aaa'
}

console.log(anyObj.id)  // 'A001'
```

```ts
const unknownObj: unknown = {
  id: 'A001',
  name: 'aaa'
}

console.log(unknownObj.id)  // 'unknownObj' is of type 'unknown'.
```

`unknown`型のオブジェクトを操作したい場合、型を作成し、型アサーションを利用する

```ts
type Obj = {
  id: string
  name: string
}

const unknownObj: unknown = {
  id: 'A001',
  name: 'aaa'
}

console.log((unknownObj as Obj).id)  // 'A001'
```

### never型の例

```ts
function throwError(message: string): never {
  throw new Error(message)
}
```

```ts
function infiniteLoop(): never {
  while (true) {}
}
```

## 6. 型エイリアス

既存の型を新たな名前で定義する機能

```ts
type StringOrNumber = string | number
const str: StringOrNumber = 'hello'
const num: StringOrNumber = 24
```

### InterfaceとTypeの違い

TSで型を作成するには`interface`か`type`を利用する

```ts
interface User {
  name: string
  age: number
}
```

```ts
type User = {
  name: string
  age: number
}
```

#### 違い1. `type`ではオブジェクトとクラスの型以外も定義が可能

`interface`ではオブジェクトとクラスの型のみ定義可能。`type`では他の型も参照できる

```ts
type RGB = 'Red' | 'Green' | 'Blue'
const rgb: RGB = 'Green'
```

#### 違い2. `interface`は拡張が可能

```ts
interface User {
  name: string
  age: number
}

// プレミアムユーザはお気に入り機能を利用できるとする
interface PremiumUser extends User {
  favorite_posts: string[]
}
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
let num = 25 as const  // OK（25のリテラル型になる）
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
const user: { name: string; age: number } = {name: 'Jhon Doe', age: 31}
```

### 読み取り専用のオブジェクト

配列と同じく`readonly`を利用

```ts
let user: { readonly name: string; age: number }
user = { name: "John", age: 20 }
user.name = "Tom"  // error
```

## 11. オプションプロパティ

`?`を付与したプロパティは省略可能になる

```ts
let user: { name: string; age?: number }
user = { name: "John" }  // `age`プロパティがなくてもエラーにならない
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
}
 
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
        console.log(value.length)
    }
}

printLength('hello')  // 5
```

> [!NOTE]
> ### typeof型演算子
>
> `typeof`は変数名から型を逆算する
>
> ```ts
> const obj = {
>     name: 'TypeScript',
>     version: 3.9
> }
> 
> type ObjectType = typeof object
> ```

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

## 23. in演算子

オブジェクトが特定のプロパティを持つか判定するのに利用できる

```ts
type Employee = {
  name: string
  email: string
}

type Manager = Employee & {
  teamId: string
}

const employee: Manager = {
  name: 'Jhon',
  email: 'test@example.com',
  teamId: 'TX200',
}

if ('teamId' in employee) {
  console.log('オブジェクトemployeeはteamIdを持っているのでこの人はManagerです')
}
```

## 24. ユーティリティ型

TS側で用意されている**型から別の型を導き出してくれる型**。`function`が実行時の世界の関数だとしたら、ユーティリティ型は型の世界の関数といったイメージ

`Partial`、`Pick`、`Omit`、`ReturnType`、`Record`、`NonNullable`などがある

### Pick型

```ts
Pick<T, Keys>
```

型`T`から`Keys`に**指定したキーだけを含むオブジェクト型**を返す。以下のように、必要なプロパティだけのオブジェクト型を簡単に作成できる

```ts
type User = {
  firstName: string
  lastName: string
  age?: number
  address?: string
  createdAt: string
  updatedAt: string
}

type UserName = Pick<User, 'firstName' | 'lastName'>

const username: UserName = {
  'firstName': 'Jane',
  'lastName': 'Doe',
}
```

### Omit型

```ts
Omit<T, Keys>
```

オブジェクトの型`T`から`Keys`で**指定したプロパティを除いたオブジェクト型**を返す。以下のように、特定のプロパティを削除したオブジェクト型を簡単に作成できる

```ts
type User = {
  firstName: string
  lastName: string
  age?: number
  address?: string
  createdAt: string
  updatedAt: string
}

type UserName = Omit<User, 'age' | 'address' | 'createdAt' | 'updatedAt'>

const username: UserName = {
  'firstName': 'Jane',
  'lastName': 'Doe',
}
```

### Record型

```ts
Record<Keys, T>
```

プロパティのキーが`Keys`型で、プロパティの型が`T`であるオブジェクト型を返す。特定の型のキーに対して特定の型の値をマッピングする場合に便利

```ts
type UserId = string
type User = { name: string }

const users: Record<UserId, User> = {
  'A001': { name: 'Alice' },
  'A002': { name: 'Bob' },
}
```

## 25. Conditional Types

Conditional Typesは条件付き型、型の条件分岐、条件型などと呼ばれる。三項演算子のように`?`と`:`を使って`T extends U ? X : Y`のように書く。これは`T`が`U`に割り当て可能である場合、`X`になり、そうでない場合は`Y`になる

```ts
type IsString<T> = T extends string ? true : false
const a: IsString<"a"> = true
```

### 具体例

```ts
type MessageType = 'success' | 'error' | 'info'

// メッセージの内容に応じて色を変える
type MessageColor<T> = T extends 'success' 
  ? 'green'
  : T extends 'error'
  ? 'red'
  : 'blue'

const getMessageStyle = (type: MessageType) => {
  const color: MessageColor<typeof type> = 
    type === 'success' ? 'green' :
    type === 'error' ? 'red' : 
    'blue'

  return { color }
}

console.log(getMessageStyle('success'))  // { color: 'green' }
console.log(getMessageStyle('error'))    // { color: 'red' }
console.log(getMessageStyle('info'))     // { color: 'blue' }
```

## 26. satisfies演算子

オブジェクトや配列などの変数が型を「満たしている」とコンパイラに示すための仕組み

`satisfies`の必要性を論じるために、まずは`as const`と`型注釈（型アノテーション）`を組み合わせたときに発生する現象を確認する

下の例は`as const`を利用して、ユーザ情報を書き換えられないようにしたいと考えて作成したプログラムである

```ts
type User = {
  id: string
  name: string
}

// 型注釈なし、as constあり
const user1 = { id: "001", name: "Alice" } as const

// 型注釈あり、as constあり
const user2: User = { id: "002", name: "Bob" } as const

user1.name = "Eve"  // error
user2.name = "Jhon" // 上書きできてしまう
```

`as const`を付与した場合、オブジェクトはリテラル型かつ`readonly`なオブジェクトとなり、`user1.name`のようなプロパティの書き換えはエラーとなる。これが普通

しかし、`user2`のように型注釈`: User`と`as const`を併用すると、意図に反して、プロパティを書き換えられる状況が生まれる。 **`as const`で得た`readonly`の特性が、型注釈によって打ち消されてしまう現象が起こる**

もうひとつ例を見る  
下の例では`User`型に`email`プロパティを追加した

```ts
type User = {
  id: string
  name: string
  email: string
}

// 型注釈なし、as constあり
const user1 = { id: "001", name: "Alice" } as const

// 型注釈あり、as constあり
// 宣言時点でエラー
const user2: User = { id: "002", name: "Bob" } as const

user1.name = "Eve"
user2.name = "Jhon"
```
`user2`は変数宣言の時点でエラーが出る。話は単純で、型が記述されているからで、「`email`が足りていない！」とエラーが出ているだけである

一方、`user1`は、`User`型と一致していなくてもエラーになっていない。これは「`User`型に違反しているのか、たまたま今までが`User`型と一致していただけなのか」を推論しようがないからである

このように`as const`のみでは型の決定を制御できないケースが出てくる。今回のように`as const`のみの利用だと、`email`のようなプロパティの追加漏れに気づけないリスクがある

`satisfies`を使うと、オブジェクトが指定した型を満たしているかコンパイラが検証するが、変数自体をその型に固定せず、推論結果を優先するようになる

```ts
const user1 = { id: "001", name: "Alice" } satisfies User
const user2 = { id: "002", name: "Bob" } as const satisfies User
```

また`as const`を併用することで、型を満たしたうえでリテラル型情報や`readonly`特性を保てる。`as const satisfies User`と書けば、`User`型を満たしているかチェックしつつ、`as const`によるリテラル型や`readonly`特性を損なわずに保持可能である

先ほどの`User`型に`email`プロパティを追加したとき、開発者が気づけるかの点についても確認しておく

```ts
type User = {
  id: string
  name: string
  email: string
}

// does not satisfy the expected type 'User'.
const user1 = { id: "001", name: "Alice" } satisfies User

// does not satisfy the expected type 'User'.
const user2 = { id: "002", name: "Bob" } as const satisfies User
```

このように`as const satisfies T`というパターンは便利。`as T`はコンパイラに`T`型であると信じさせるアサーションであり、使い方によっては欺くことができてしまう。`satisfies T`は、型と一致しているかを厳密に判定するため、不正な値を紛れ込ませるリスクを減らせる

## 27. 参考

- [TypeScript入門『サバイバルTypeScript』](https://typescriptbook.jp/)
