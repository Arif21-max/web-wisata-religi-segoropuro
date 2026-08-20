<?php

use App\Http\Controllers\Admin\ArtikelController as AdminArtikelController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BarangHilangController as AdminBarangHilangController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\BukuTamuController as AdminBukuTamuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KontakController as AdminKontakController;
use App\Http\Controllers\Admin\SpotWisataController as AdminSpotWisataController;
use App\Http\Controllers\BarangHilangController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BukuTamuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SejarahController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SpotWisataController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::middleware('catat.pengunjung')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Redirect 301 URL lama yang menggunakan ID ke URL berbasis slug.
    Route::get('/sejarah/{id}', [SejarahController::class, 'redirectToSlug'])->where('id', '[0-9]+');
    Route::get('/berita/{id}', [BeritaController::class, 'redirectToSlug'])->where('id', '[0-9]+');

    Route::get('/sejarah', [SejarahController::class, 'index'])->name('sejarah.index');
    Route::get('/sejarah/{artikel}', [SejarahController::class, 'show'])->name('sejarah.show');
    Route::get('/spot-wisata', [SpotWisataController::class, 'index'])->name('spot-wisata.index');
    Route::get('/spot-wisata/{spot}', [SpotWisataController::class, 'show'])->name('spot-wisata.show');
    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/{berita}', [BeritaController::class, 'show'])->name('berita.show');
    Route::get('/buku-tamu', [BukuTamuController::class, 'index'])->name('buku-tamu.index');
    Route::post('/buku-tamu', [BukuTamuController::class, 'store'])->middleware('throttle:5,60')->name('buku-tamu.store');
    Route::get('/barang-hilang', [BarangHilangController::class, 'index'])->name('barang-hilang.index');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.attempt');

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('artikel', AdminArtikelController::class)->except('show');
        Route::resource('berita', AdminBeritaController::class)->except('show')->parameters(['berita' => 'berita']);
        Route::resource('spot-wisata', AdminSpotWisataController::class)->except('show')->parameters(['spot-wisata' => 'spot']);
        Route::post('spot-wisata/{spot}/foto', [AdminSpotWisataController::class, 'addPhotos'])->name('spot.foto-tambah');
        Route::resource('buku-tamu', AdminBukuTamuController::class)->only(['index', 'destroy'])->parameters(['buku-tamu' => 'ulasan']);
        Route::resource('barang-hilang', AdminBarangHilangController::class)->except('show')->parameters(['barang-hilang' => 'item']);
        Route::post('barang-hilang/{item}/toggle', [AdminBarangHilangController::class, 'toggle'])->name('barang-hilang.toggle');
        Route::get('kontak', [AdminKontakController::class, 'edit'])->name('kontak.edit');
        Route::put('kontak', [AdminKontakController::class, 'update'])->name('kontak.update');
    });
});