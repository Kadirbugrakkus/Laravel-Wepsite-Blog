<?php

use Illuminate\Support\Facades\Route;


/* Back Route */

Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function ()
{
    Route::get('giris', 'App\Http\Controllers\Back\Auths@login')->name('login');
    Route::post('giris', 'App\Http\Controllers\Back\Auths@loginPost')->name('login.post');
});


Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function ()
{
    Route::get('panel','App\Http\Controllers\Back\Dashboard@index')->name('dashboard');

    // İçerik Route'ları
    Route::get('icerikler/silinenler','App\Http\Controllers\Back\AdminContent@trashed')->name('trashed.content');
    Route::resource('icerikler', 'App\Http\Controllers\Back\AdminContent');
    Route::get('/switch','App\Http\Controllers\Back\AdminContent@switch')->name('switch');
    Route::get('/deletecontent/{id}','App\Http\Controllers\Back\AdminContent@delete')->name('delete.content');
    Route::get('/harddeletecontent/{id}','App\Http\Controllers\Back\AdminContent@hardDelete')->name('hard.delete.content');
    Route::get('/recovercontent/{id}','App\Http\Controllers\Back\AdminContent@recover')->name('recover.content');
    // Kategori Route'ları
    Route::get('/kategoriler','App\Http\Controllers\Back\AdminCategory@index')->name('category.index');
    Route::post('/kategoriler/create','App\Http\Controllers\Back\AdminCategory@create')->name('category.create');
    Route::post('/kategoriler/update','App\Http\Controllers\Back\AdminCategory@update')->name('category.update');
    Route::post('/kategoriler/delete','App\Http\Controllers\Back\AdminCategory@delete')->name('category.delete');
    Route::get('kategoriler/switch','App\Http\Controllers\Back\AdminCategory@switch')->name('kategoriler.switch');
    Route::get('kategoriler/getData','App\Http\Controllers\Back\AdminCategory@getData')->name('kategoriler.getdata');
    //Sayfa Route'ları
    Route::get('/sayfalar','App\Http\Controllers\Back\AdminPage@index')->name('page.index');
    Route::get('/sayfalar/Olustur','App\Http\Controllers\Back\AdminPage@create')->name('page.create');
    Route::get('/sayfalar/guncelle/{id}','App\Http\Controllers\Back\AdminPage@update')->name('page.edit');
    Route::Post('/sayfalar/guncelle/{id}','App\Http\Controllers\Back\AdminPage@updatePost')->name('page.edit.post');
    Route::post('/sayfalar/Olustur','App\Http\Controllers\Back\AdminPage@post')->name('page.create.post');
    Route::get('/sayfalar/switch','App\Http\Controllers\Back\AdminPage@switch')->name('page.switch');
    Route::post('/sayfalar/sil','App\Http\Controllers\Back\AdminPage@delete')->name('page.delete');
    Route::get('/sayfalar/siralama','App\Http\Controllers\Back\AdminPage@orders')->name('page.orders');
    //Config Route'ları
    Route::get('ayarlar','App\Http\Controllers\Back\AdminConfig@index')->name('config');
    Route::post('/ayarlar/güncelle','App\Http\Controllers\Back\AdminConfig@update')->name('update');
    //
    Route::get('cikis','App\Http\Controllers\Back\Auths@logout')->name('logout');
});




/* Front Route */

Route::get('/', 'App\Http\Controllers\Front\Homepage@index')->name('homepage');
Route::get('sayfa', 'App\Http\Controllers\Front\Homepage@index');
Route::get('/iletisim', 'App\Http\Controllers\Front\Homepage@contact')->name('contact');
Route::post('iletisim', 'App\Http\Controllers\Front\Homepage@contactpost')->name('contact.post');
Route::get('/kategori/{category}', 'App\Http\Controllers\Front\Homepage@category')->name('category');
Route::get('/{category}/{slug}', 'App\Http\Controllers\Front\Homepage@single')->name('single');
Route::get('/{sayfa}', 'App\Http\Controllers\Front\Homepage@page')->name('page');



