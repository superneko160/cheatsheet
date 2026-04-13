# 共変性と反変性

- 型の互換性の話
- 型の継承関係において、サブタイプがどのように振る舞えるかを定義する概念

> [!NOTE]
> サブタイプとあるように、下記サンプルコードは、抽象クラスで記述してあるが、普通のクラスの継承の場合も、インターフェースで実装した場合にも共通する概念である

## 共変性 - 返り値の型

子クラスのメソッドはより具体的な型を返せる

```php
class Animal {}
class Cat extends Animal {}

abstract class AnimalShelter {
    // 返り値：Animal型
    abstract public function adopt(): Animal;
}

class CatShelter extends AnimalShelter {
    // より具体的なCat型を返す（共変）
    public function adopt(): Cat {
        return new Cat();
    }
}
```

つまり、返り値の型は継承ツリーをより具体的に変えられるということ

## 反変性 - 引数の型

子クラスのメソッドは、より抽象的な型を引数に取れる

```php
class Animal {}
class Cat extends Animal {}

abstract class AnimalTrainer {
    // 引数：Cat型
    abstract public function train(Cat $cat): void;
}

class GeneralTrainer extends AnimalTrainer {
    // より抽象的なAnimal型を受け取れる（反変）
    public function train(Animal $animal): void {
        echo 'Training...';
    }
}
```

つまり、引数の型は継承ツリーをより抽象的に変えられるということ

## まとめ

- 共変性（返り値）：親Animal → 子Cat （より具体的にできる）
- 反変性（引数）：親Cat → 子Animal （より抽象的にできる）

上記の仕組みは、型安全性を保ちながら継承を柔軟に活用するためにある
