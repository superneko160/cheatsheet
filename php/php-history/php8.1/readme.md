# PHP8.1

## [Enum（列挙型）](https://www.php.net/manual/ja/language.types.enumerations.php)

PHP8.1から、取りうる値を `case` で定義するEnumが使えるようになった。定義したケース以外の値を扱わないようにできるため、状態や選択肢を明確に表現可能に

### Unit Enum

- 値を持たないEnum

```php
enum Status {
    case Draft;
    case Published;
    case Archived;
}

$status = Status::Published;
var_dump($status === Status::Published);  // bool(true)
```

### Backed Enum

- 値を持つEnum
- `string` または `int` の値を各ケースに割り当てる
- DBや外部APIとの受け渡しに使う値を定義するなどできる

```php
enum HttpStatus: int {
    case Ok = 200;
    case NotFound = 404;
    case ServerError = 500;
}

echo HttpStatus::NotFound->value;  // 404
```

### match式との組み合わせ

PHP8.0で導入された match式は、値を返し、比較には厳密な同値比較（ `===` ）を使用する。Enumと組み合わせると、状態ごとの処理を簡潔に記述できるので相性抜群。すべてのケースを列挙しておけば、扱う状態も読み取りやすくなる

```php
enum OrderStatus {
    case Pending;
    case Paid;
    case Shipped;
    case Cancelled;
}

function messageFor(OrderStatus $status): string {
    return match ($status) {
        OrderStatus::Pending => 'ご注文を受け付けました',
        OrderStatus::Paid => 'お支払いが完了しました',
        OrderStatus::Shipped => '商品を発送しました',
        OrderStatus::Cancelled => 'ご注文はキャンセルされました',
    };
}

echo messageFor(OrderStatus::Shipped);  // 商品を発送しました
```
