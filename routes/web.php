<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/harian/{month}/{year}', 'HomeController@ajax_harian')->name('ajax_harian');
Route::get('/mingguan', 'HomeController@mingguan')->name('mingguan');
Route::get('/bulanan', 'HomeController@bulanan')->name('bulanan');
Route::get('/bulanan/{month}/{year}', 'HomeController@ajax_bulanan')->name('ajax_bulanan');
Route::get('/tahunan', 'HomeController@tahunan')->name('tahunan');
Route::get('/transaksi/pemasukan', 'HomeController@pemasukan')->name('pemasukan');
Route::get('/transaksi/pengeluaran', 'HomeController@pengeluaran')->name('pengeluaran');
Route::get('/kategori/pengeluaran', 'HomeController@kategoriPengeluaran')->name('kategori.pengeluaran');
Route::get('/kategori/pemasukan', 'HomeController@kategoriPemasukan')->name('kategori.pemasukan');

// DELETE
Route::get('/kategori/hapus/{id}', 'KategoriController@hapus')->name('kategori.hapus');

// PDF View
Route::get('/pdf', 'HomeController@pdf')->name('pdf.reporting');

// POST
Route::post('/kategori/pengeluaran', 'KategoriController@index')->name('tambah.kategori');
Route::post('/transaksi/pengeluaran', 'TransaksiController@pengeluaran')->name('transaksi.pengeluaran');
Route::post('/transaksi/pemasukan', 'TransaksiController@pemasukan')->name('transaksi.pemasukan');
