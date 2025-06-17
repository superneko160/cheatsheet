'use strict';

// 戦闘機の画像
const planeImage = document.getElementById('plane');
// 戦闘機の画像のサイズ（このサイズぶん移動。そうでないとズレが生じる）
const planeWidth = 50;
const planeHeight = 50;
// 戦闘機の位置
let x = 0;  // x座標（横）
let y = 0;  // y座標（縦）

// なんらかのキー押下時
window.addEventListener('keydown', function(e) {
    console.log(e.key);  // 押下されたキーの種類

    // 下矢印ボタン押下時
    if (e.key === 'ArrowDown') {
        y = y + planeHeight;
    }

    // 戦闘機（画像）を座標を変更したぶんだけ動かす
    planeImage.style.left = x + "px";
    planeImage.style.top = y + "px";
});
