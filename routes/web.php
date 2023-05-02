<?php

use App\Models\Message;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Record;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function (Request $request) {
        $records = Record::query()->paginate();
        if ($request->wantsJson()) {
            return $records;
        }

        return Inertia::render('Dashboard', [
            'records' => $records,
        ]);
    })->name('dashboard');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
