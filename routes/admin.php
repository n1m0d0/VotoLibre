<?php

use Illuminate\Support\Facades\Route;

Route::view('user', 'pages.user')->name('user');
Route::view('department', 'pages.department')->name('department');
Route::view('province', 'pages.province')->name('province');
Route::view('municipality', 'pages.municipality')->name('municipality');
Route::view('district', 'pages.district')->name('district');
Route::view('zone', 'pages.zone')->name('zone');
Route::view('enclosure', 'pages.enclosure')->name('enclosure');
Route::view('station', 'pages.station')->name('station');
Route::view('party', 'pages.party')->name('party');
Route::view('position', 'pages.position')->name('position');
