# ES2024

## [`Object.groupBy()`](https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Object/groupBy)

配列やオブジェクトに対してグルーピング処理できる。Javaの `Collectors.groupingBy()` に近い

```js
const users = [
    { 'name': 'Alice', 'age': 23, 'gender': 'female', 'hobby': 'tennis' },
    { 'name': 'Bob', 'age': 35, 'gender': 'male', 'hobby': 'guitar' },
    { 'name': 'David', 'age': 20, 'gender': 'male', 'hobby': 'guitar' },
    { 'name': 'Jhon', 'age': 25, 'gender': 'male', 'hobby': 'chess' },
    { 'name': 'Eve', 'age': 29, 'gender': 'female', 'hobby': 'chess' },
    { 'name': 'Tom', 'age': 40, 'gender': 'male', 'hobby': 'tennis' },
];

// hobbpyプロパティでグルーピング
Object.groupBy(users, ({ hobby }) => hobby);

/*
{
    chess:[
        {name: 'Jhon', age: 25, gender: 'male', hobby: 'chess'},
        {name: 'Eve', age: 29, gender: 'female', hobby: 'chess'},
    ]
    guitar:[
        {name: 'Bob', age: 35, gender: 'male', hobby: 'guitar'},
        {name: 'David', age: 20, gender: 'male', hobby: 'guitar'},
    ],
    tennis:[
        {name: 'Alice', age: 23, gender: 'female', hobby: 'tennis'},
        {name: 'Tom', age: 40, gender: 'male', hobby: 'tennis'},
    ],
}
*/
```

```js
// 対象者と対象外という条件でグルーピング
Object.groupBy(users, ({ name, age, gender }) => {
    if (age > 30) {
        return '対象者';
    } else if (age >= 25 && gender === 'male') {
        return '対象者';
    }
    return '対象外';
});

/*
{
    対象外: [
        {name: 'Alice', age: 23, gender: 'female', hobby: 'tennis'},
        {name: 'David', age: 20, gender: 'male', hobby: 'guitar'},
        {name: 'Eve', age: 29, gender: 'female', hobby: 'chess'},
    ],
    対象者: [
        {name: 'Bob', age: 35, gender: 'male', hobby: 'guitar'},
        {name: 'Jhon', age: 25, gender: 'male', 'hobby': 'chess'},
        {name: 'Tom',  age: 40, gender: 'male', hobby: 'tennis'},
    ],
}
*/
```
