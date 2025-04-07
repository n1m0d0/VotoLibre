<?php

use App\Models\Record;
use Illuminate\Support\Facades\Route;

Route::view('tracking', 'pages.tracking')->name('tracking');
Route::get('station-votes/{record}', function (Record $record) {
    return view('pages.station-votes', compact('record'));
})->name('station-votes');
