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
Route::get('/', 'SiteController@home')->name('index');

/*=============================================Tin tức================================*/
Route::get('tin-tuc', 'SiteController@news')->name('news');
Route::get('tin-tuc/{slug}-{id}', 'SiteController@newsDetail')->where(array('slug' => '[a-z0-9\-]+', 'id' => '[0-9]+'))->name('news-detail');
Route::get('tong-hop-ma-swift-code-ngan-hang-viet-nam', function(){
	return view('pages.swift_code');
})->name('swift-code');
/*=============================================end====================================*/

/*=============================================Chi nhánh==============================*/
Route::get('chi-nhanh-ngan-hang-{slug}', 'SiteController@bank')->name('bank');

Route::get('chi-nhanh/ngan-hang-{bankName}/{province}', 'SiteController@provinceBank')->where(array('bankName' => '[a-z0-9\-]+', 'province' => '[a-z0-9\-]+'))->name('province-bank');

Route::get('chi-nhanh/ngan-hang-{bankName}/{province}/{disctrict}', 'SiteController@districtBank')->name('district-bank');

Route::get('ngan-hang-{bankName}-{bankId}', 'SiteController@bankIntro')->where(array('bankName' => '[a-z0-9\-]+', 'bankId' => '[0-9\-]+'))->name('bank-intro');

Route::get('ngan-hang/{bankName}/chi-nhanh/{province}/{branch}-{id}', 'SiteController@bankBranchDetail')->name('bank-branch-detail')->where(array('branch' => '[a-z0-9\-]+', 'id' => '[0-9]+'));
/*=============================================end=====================================*/

/*=============================================ATM=====================================*/
Route::get('tim-atm', 'SiteController@atmList')->name('atm');

Route::get('tim-atm/{bank}-{district}-{province}-{bankId}-{provinceId}-{districtId}', 'SiteController@districtAtm')->where(array('bank' => '[a-z0-9\-]+', 'district' => '[a-z0-9\-]+', 'province' => '[a-z0-9\-]+', 'bankId' => '[0-9]+', 'provinceId' => '[0-9]+', 'districtId' => '[0-9]+'))->name('district-atm');

Route::get('tim-atm/{bank}-{province}-{bankId}-{provinceId}', 'SiteController@provinceAtm')->where(array('bank' => '[a-z0-9\-]+', 'province' => '[a-z0-9\-]+', 'bankId' => '[0-9]+', 'provinceId' => '[0-9]+'))->name('province-atm');

Route::get('tim-atm/{bank}-{id}', 'SiteController@bankAtm')->where(array('bank' => '[a-z0-9\-]+', 'id' => '[0-9]+'))->name('bank-atm');

Route::post('search-atm', 'SiteController@atmSearch')->name('atm-search');

Route::get('cay-atm/{province}', 'SiteController@atmProvince')->name('atm-province');

Route::get('atm/{bankName}/{address}-{id}', 'SiteController@atmDetail')->where(array('address' => '[0-9a-z\-]+', 'id' => '[0-9]+'))->name('atm-detail');
/*=============================================End=====================================*/

/*=============================================Quận/Huyện=================================*/
Route::post('district', 'SiteController@getDistrict')->name('district');
//Route::post('district-the-bank', 'SiteController@getDistrictTheBank')->name('district-the-bank');
/*=============================================End=======================================*/

/*==============================================Tỷ giá===================================*/
Route::get('ty-gia/{bank}-{id}', 'SiteController@exchangeRate')->where(array('bank' => '[a-z0-9\-]+','id' => '[0-9]+'))->name('exchange-rate');
Route::get('ty-gia/{bank}-{id}/ngay-{date}', 'SiteController@exchangeRateDate')->where(array('bank' => '[a-z0-9\-]+','id' => '[0-9]+', 'date' => '[-/a-zA-Z0-9]+'))->name('exchange-rate-date');
Route::post('ty-gia/tim-kiem/{bankId}', 'SiteController@exchangeRateSearch')->name('exchange-rate-search');
/*==============================================End======================================*/
Route::post('search', 'SiteController@search')->name('search');

/*==============================================Lãi suất================================*/
Route::get('lai-suat-{bank}-{id}', 'SiteController@interestRate')->where(array('bank' => '[a-z0-9\-]+','id' => '[0-9]+'))->name('interest-rate');
/*==============================================End=====================================*/

/*===============================================Tỷ giá==================================*/
Route::post('get-exchange', 'SiteController@getExchange')->name('get-exchange');
/*===============================================End=====================================*/

/* =================================================clone================================*/
//Route::get('clone-atm', 'CloneController@atm'); lấy ATM trang the bank
//Route::get('tool-the-bank', 'CloneController@theBank') lấy ATM trang thebank;
//Route::get('clone', 'CloneController@getBranch');
Route::get('clone-branch', 'CloneController@getBranch');
Route::get('get-atm', 'CloneController@getAtm');
Route::get('ty-gia', 'CloneController@tyGia');
Route::get('update', 'CloneController@updateDb');
Route::get('msb', 'CloneController@msm');
/* ====================================================end==============================*/

/*======================================================Admin============================*/
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
	Route::get('/', 'Admin\SiteController@home')->name('admin.home');
	Route::group(['prefix' => 'news'], function () {
		Route::get('news/add', 'Admin\SiteController@newsAddForm')->name('admin.news.add.form');
		Route::post('news-add', 'Admin\SiteController@newsAdd')->name('admin.news.add');
		Route::get('news/edit/{id}', 'Admin\SiteController@newsEditForm')->name('admin.news.edit.form');
		Route::post('news/edit/{id}', 'Admin\SiteController@newsEdit')->name('admin.news.edit');
		Route::get('news/delete/{id}', 'Admin\SiteController@newsDelete')->name('admin.news.delete');
	});

	Route::group(['prefix' => 'bank'], function () {
		Route::get('list', 'Admin\SiteController@bankList')->name('admin.bank.list');
		Route::get('edit/{id}', 'Admin\SiteController@bankEditForm')->name('admin.bank.edit.form');
		Route::post('edit/{id}', 'Admin\SiteController@bankEdit')->name('admin.bank.edit');
		Route::get('interest-rate/{id}', 'Admin\SiteController@interestRateForm')->name('admin.interest.rate.form');
	});
});
/*=======================================================End==============================*/
