<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[
    'as'=>'trang-chu',
    'uses'=>'PageController@getIndex'
]);
Route::get('loai-san-pham/{type}',[
    'as'=>'loaisanpham',
    'uses'=>'PageController@getLoaiSp'
]);
Route::get('chi-tiet-san-pham/{idsp}',[
    'as'=>'chitietsanpham',
    'uses'=>'PageController@getChitiet'
]);
Route::get('lien-he',[
    'as'=>'lienhe',
    'uses'=>'PageController@getLienhe'
]);
Route::get('gioi-thieu',[
    'as'=>'gioithieu',
    'uses'=>'PageController@getGioithieu'
]);

Route::get('add-to-card/{id}',
    ['as'=>'themgiohang',
    'uses'=>'PageController@getAddtoCart']
);
Route::get('delete-cart/{id}',
    ['as'=>'xoagiohang',
    'uses' =>'PageController@getDelItemCart']
);

Route::get('dat-hang',[
    'as'=>'dathang',
    'uses'=>'PageController@getDatHang'
]);
Route::get('dat-hang2',
['as'=>'dathang2',
'uses'=>'PageController@postCheckout']
);

Route::get('dang-nhap',[
    'as'    => 'dangnhap',
    'uses'  => 'PageController@getLogin'
]);

Route::get('dang-ky',[
    'as'    =>'dangky',
    'uses'  =>'PageController@getSignup'
]);
Route::post('dang-ky',[
    'as'    =>'dangky',
    'uses'  =>'PageController@postSignup'
]);
