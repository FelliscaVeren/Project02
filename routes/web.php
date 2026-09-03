<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('ppic.calendar');
});

Route::prefix('ppic')->name('ppic.')->group(function() {
    Route::get('/calendar', function () { return view('ppic.calendar'); })->name('calendar');
    Route::get('/create/step-1', function () { return view('ppic.create-step-1'); })->name('create.step1');
    Route::get('/create/step-2', function () { return view('ppic.create-step-2'); })->name('create.step2');
});

Route::prefix('gudang')->name('gudang.')->group(function() {
    Route::get('/stok', function () { return view('gudang.stok'); })->name('stok');
});

Route::prefix('approval')->name('approval.')->group(function() {
    Route::get('/', function () { return view('approval.index'); })->name('index');
    Route::get('/review', function () { return view('approval.review'); })->name('review');
});

Route::prefix('produksi')->name('produksi.')->group(function() {
    Route::get('/alokasi', function () { return view('produksi.alokasi-man'); })->name('alokasi');
});

Route::prefix('spk')->name('spk.')->group(function() {
    Route::get('/detail', function () { return view('spk.detail'); })->name('detail');
});

Route::get('/dokumen/material', function () { return view('dokumen.material'); })->name('dokumen.material');


