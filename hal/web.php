<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login/proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login/update/{id}', [AdminController::class, 'update'])->name('login-update');
Route::post('/login/akun-delete/{id}', [AdminController::class, 'akun_delete'])->name('akun-delete');

Route::get('/transaksi/pdf/all', [PDFController::class, 'generatePDFAll'])->name('transaksi.pdf.all');
Route::get('/transaksi/pdf/{id}', [PDFController::class, 'generatePDFSingle'])->name('transaksi.pdf.single');

// Route::middleware('admin')->group(
//     function () {
Route::get('/admin/home/search', [AdminController::class, 'search'])->name('adminSearch');
Route::post('/admin/register-proses/', [AdminController::class, 'registar_proses'])->name('admin-register');
Route::get('/admin/home', [AdminController::class, 'index'])->name('admin-home');
Route::get('/admin/kelolaakun', [AdminController::class, 'kelolaakun'])->name('admin-kelolaakun');
Route::get('/admin/transaksi', [AdminController::class, 'transaksi'])->name('admin-transaksi');
Route::post('/admin/konfirmasi-transaksi/{id}', [AdminController::class, 'konfirmasi_transaksi'])->name('admin.konfirmasi-transaksi');
Route::get('/admin/detail-transaksi/{id}', [AdminController::class, 'detail_transaksi'])->name('admin.detail-transaksi');
//     }
// );

// Route::middleware('bank')->group(
//     function () {
    Route::get('/bank/home', [BankController::class, 'index'])->name('bank-home');
    Route::get('/bank/transfer', [BankController::class, 'transferdashboard'])->name('bank-transfer');
    Route::get('/bank/kelolaakun', [BankController::class, 'kelolaakun'])->name('bank-kelolaakun');
    Route::get('/bank/home/search', [BankController::class, 'bank_Search'])->name('banksearch');
    Route::post('/bank/home/kirimuang', [BankController::class, 'masukkan_dana_bank'])->name('masukkan-dana-bank');
    Route::post('/bank/home/tarikuang', [BankController::class, 'keluarkan_dana_bank'])->name('keluarkan-dana-bank');
    Route::post('/bank/home/transfer', [BankController::class, 'transfer_dana_bank'])->name('transfer-dana-bank');
    Route::post('/bank/home/ambiluang', [BankController::class, 'keluarkan_dana_bank'])->name('ambiluang-dana-bank');
    Route::post('/bank/home/konfirmasi/{transaksiId}', [BankController::class, 'konfirmasi_transaksi'])->name('konfirmasi-transaksi');
// });

// Route::middleware('user')->group(
//     function () {
    Route::get('/user/home', [UserController::class, 'index'])->name('user-home');
    Route::get('/user/transfer', [UserController::class, 'UserTransferDashboard'])->name('user-transfer');
    Route::post('/user/bank/home/kirimuang', [UserController::class, 'masukkan_dana'])->name('masukkan-dana-user');
    Route::post('/user/bank/home/ambiluang', [UserController::class, 'keluarkan_dana'])->name('ambiluang-dana-user');
    Route::post('/user/bank/home/transfer', [UserController::class, 'transfer_dana'])->name('transfer-dana-user');
//     }
// );
