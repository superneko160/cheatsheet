# Branded Types

## TypeScriptの型の弱点

- TSでは、似た構造を持つ型が互いに互換性を持ってしまうことで、意図しない代入や関数呼び出しが可能になり、論理的なエラーを引き起こす可能性がある
- このような問題に対処するためにBranded Types（ブランド型）という手法がある
- 型システムを拡張して名前的型システム（nominal typing）の特性を模倣し、似た構造でも異なる役割を持つ型を区別できるようにする手法

## 構造的型システムと名前的型システム

- TSの型システムを理解する上で最も重要な概念の一つが「構造的型システム」
- 「構造型システム」は Java や C# などの「名前的型システム」とは対照的な概念で、TypeScript の型の互換性は型の名前ではなく、その構造（プロパティや型）に基づいて判断される

## 構造的型システムの基本概念

- 構造的型システムでは、ある型が他の型と互換性を持つかどうかは、型の内部構造に基づいて決定される。簡単に言えば、**同じ形をしていれば、同じ型と見なす**

```ts
// ユーザ認証用の型
interface UserCredentials {
  id: string;
  password: string;
}

// DB接続設定用の型
interface DatabaseConfig {
  id: string;
  password: string;
}

// DBに接続する関数
function connectToDatabase(config: DatabaseConfig) {
  // データベース接続ロジック
}

// ユーザ認証情報
const userCredentials: UserCredentials = {
  id: "user123",
  password: "secretPassword",
};

// 型エラーは発生しない
connectToDatabase(userCredentials);
```

このコードでは、`UserCredentials` と `DatabaseConfig` は構造的に同一のため、TypeScript は何のエラーも出ない。しかし、これらは明らかに異なる目的を持つ型である。データベース接続情報にユーザー認証情報を渡してしまうことは、セキュリティリスクやバグの原因となり得る

## Branded Types の定義と目的

Branded Types とは、既存の型に特別な「ブランド」を付与し、構造は同じでも型システム上では区別できるようにする手法。これにより、TypeScript の構造的型システム内で擬似的な名前的型システムを実現する

## 名前的型システム（nominal typing）のエミュレーション方法

TSの型システムは基本的に構造的だが、名前的型システムの特性を模倣するいくつかの方法がある。その中核となるアイデアは、型に固有の「マーカー」や「タグ」を追加すること

この手法は、型の互換性チェックを利用する。例えば、型 A に型 B には存在しない特別なプロパティを追加する

一般的な方法は、インターセクション型（`&`）を使用して、既存の型に特別なプロパティを追加するやり方

1. 特別なプロパティを追加する（プロパティブランディング）
2. ユニークなシンボルを使用する（シンボルブランディング）
3. クラスの private フィールドを活用する

これらの方法はすべて、型に固有の「指紋」を追加し、構造が似ている他の型との区別を可能にする

## 基本的な Branded Types の実装パターン

インターセクション型を使用して型にユニークなプロパティを追加する方法

```ts
// 基本的なブランディングの例
type UserId = string & { readonly __brand: "userId" };
type OrderId = string & { readonly __brand: "orderId" };

// 型の作成関数（型アサーションを使用）
// ユーザID作成
function createUserId(id: string): UserId {
  return id as UserId;
}

// 注文ID作成
function createOrderId(id: string): OrderId {
  return id as OrderId;
}

// 使用例
const userId = createUserId("user-123");
const orderId = createOrderId("order-456");

// 型の安全性を確認
// UserIdのみ受け付ける
function processUser(id: UserId) {
  console.log(`Processing user: ${id}`);
}

processUser(userId); // OK
processUser(orderId); // エラー: 'OrderId' 型は 'UserId' 型に割り当てられません
```

上コードでは、`UserId` と `OrderId` の両方が基本的には単なる文字列だが、異なるブランドプロパティ（`__brand`）を持つことで型システム上では区別される。JavaScript 実行時には、これらのブランドプロパティは存在しないが、TypeScript のコンパイル時のチェックには影響する


## より洗練されたBranded Type

```ts
// 再利用可能なブランド型
type Branded<T, Brand> = T & { readonly __brand: Brand };

// 具体的なブランド型
type Meters = Branded<number, "meters">;
type Seconds = Branded<number, "seconds">;

// 型の作成関数
function meters(value: number): Meters {
  return value as Meters;
}

function seconds(value: number): Seconds {
  return value as Seconds;
}

// 使用例
const distance = meters(100);
const time = seconds(60);

// 型の安全性を確認
function calculateSpeed(distance: Meters, time: Seconds): number {
  return distance / time; // m/s の計算
}

calculateSpeed(distance, time); // OK
calculateSpeed(time, distance); // エラー: 引数の型が一致しません
```

このパターンでは、`Branded` というジェネリック型を定義し、任意の型 `T` とブランド識別子 `Brand` を組み合わせることで、さまざまなブランド型を簡単に作成可能

## Branded Types を使うべき場面

1. **異なる意味を持つ同じ型の値を区別する必要がある場合**：単位を持つ値（距離、時間、金額など）、異なる種類の ID（ユーザー ID、注文 ID）、または異なる形式の文字列（メールアドレス、URL、電話番号）など
2. **特定の条件を満たす値のみを受け入れたい場合**：正の数値、割合（0〜100%）、ソート済み配列など、特定の制約がある値
3. **関数の引数の順序や種類による混同を防ぎたい場合**：同じ型の複数のパラメータを持つ関数（例：`calculateRectangleArea(width, height)`）で、パラメータの順序を間違えることを防げる

## Branded Typesを使わない場面

1. **インターフェースやクラスで十分な場合**：値の構造（プロパティ）で区別できる場合は、通常のインターフェースで十分
2. **単純な関数でのオーバーヘッドが大きすぎる場合**：小規模な関数や単純なユーティリティでは、過度な型の複雑さが読みやすさを損なう可能性がある
3. **通常の列挙型やユニオン型で十分な場合**：有限個の値セットを表現する場合は、`enum` や文字列リテラルのユニオン型の方が適切
