'use strict';

const GET_AREA_CLASS_URL = 'https://app.rakuten.co.jp/services/api/Travel/GetAreaClass/20131024';
const API_KEY = '';  // ※アプリケーションIDここに設定すること

// HTML要素
const pref_select = document.getElementById('pref-select');  // 都道府県のセレクトボックス
const city_select = document.getElementById('city-select');  // 市のセレクトボックス

// 国、都道府県、市のデータを格納しておく用
let areaData = [];

/**
 * DOM構築後に実行
 */
document.addEventListener('DOMContentLoaded', async () => {
    // 国、都道府県、市のデータをAPIから取得
    areaData = await getAreaData();
    // 都道府県のデータからselect要素を作成
    insertPrefInSelect(areaData['areaClasses']['largeClasses'][0]['largeClass'][1]['middleClasses']);
    // 市のセレクトボックスを作成（初期は北海道のデータで作成しておく）
    insertCityInSelect(areaData['areaClasses']['largeClasses'][0]['largeClass'][1]['middleClasses'][0]['middleClass'][1]['smallClasses']);
});

/**
 * 都道府県のセレクトボックス変更時、市のセレクトボックスのoption要素を追加
 */
pref_select.addEventListener('change', () => {
    // 市のセレクトボックスを初期化
    resetCityInSelect();
    // 市のセレクトボックスを作成
    insertCityInSelect(areaData['areaClasses']['largeClasses'][0]['largeClass'][1]['middleClasses'][pref_select.value]['middleClass'][1]['smallClasses']);
});

/**
 * 国、都道府県、市のデータを楽天API（GetAreaClass）から取得
 * @return {object} 国、都道府県、市のデータ
 */
async function getAreaData() {

    // パラメータ
    const params = {
        method : 'POST',  // fetchはGETではbodyを登録できないのでPOSTに設定
        body : JSON.stringify({
            applicationId : API_KEY,  //  APIキー
            format: 'json'  //  取得するデータの形式
        })
    };

    try {
        // 楽天APIからデータ取得
        const response = await fetch(GET_AREA_CLASS_URL, params);
        return await response.json();
    } catch (error) {
        console.error(error);
    }
}

/**
 * セレクトボックスに都道府県を追加
 * @param {array} prefData  47都道府県分のデータ
 */
function insertPrefInSelect(prefData) {
    // 取得した都道府県データをもとにoption要素を追加
    prefData.forEach((pref, index) => {
        // option要素を作成
        const pref_option = document.createElement('option');
        // name属性、value属性、テキストを設定
        pref_option.setAttribute('name', pref['middleClass'][0]['middleClassCode']);
        pref_option.value = index;
        pref_option.textContent = pref['middleClass'][0]['middleClassName'];
        // option要素を追加
        pref_select.appendChild(pref_option);
    });
}

/**
 * セレクトボックスに市を追加
 * @param {array} cityData  市のデータ
 */
function insertCityInSelect(cityData) {
    // 取得した市のデータをもとにoption要素を追加
    cityData.forEach(city => {
        // option要素を作成
        const city_option = document.createElement('option');
        // name属性、テキストを設定
        city_option.setAttribute('name', city['smallClass'][0]['smallClassCode']);
        city_option.textContent = city['smallClass'][0]['smallClassName'];
        // option要素を追加
        city_select.appendChild(city_option);
    });
}

/**
 * 市のセレクトボックスの初期化
 */
function resetCityInSelect() {
    // 市のセレクトボックスの子要素を全削除
    while (city_select.firstChild) {
        city_select.removeChild(city_select.firstChild);
    }
}
