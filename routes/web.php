<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/lapor', function () {
    return view('public.lapor');
});

Route::get('/lacak', function () {
    return view('public.lacak');
});

Route::get('/survei', function () {
    return view('public.survei');
});

Route::get('/armada', function () {
    return view('public.armada');
});

Route::get('/tentang', function () {
    return view('public.tentang');
});

Route::get('/api/armada-aktif', function () {
    return response()->json([
        'status' => true,
        'message' => 'Daftar armada aktif berhasil diambil.',
        'data' => \App\Models\GpsVehicleCache::where('acc', 1)->get(),
    ]);
});
