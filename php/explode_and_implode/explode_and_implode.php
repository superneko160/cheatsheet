<pre>
<?php

/**
 * explode(区切り文字, 対象となる文字列)
 * 文字列を指定した区切り文字で分割し、配列にして返す
 */
$str = 'PHP/JavaScript/Python';
$result = explode('/', $str);  // 文字列は / で区切られているので第1引数に / を指定
print_r($result);  // Array: [PHP, JavaScript, Python]

print '<hr>';

/**
 * implode(区切り文字, 対象となる配列)
 * 配列を指定した区切り文字で結合し、文字列として返す
 */
$data = ['PHP', 'JavaScript', 'Python'];
$result = implode('/', $data);  // 文字列を / で結合したいので第1引数に / を指定
print $result;  // String: PHP/JavaScript/Python
