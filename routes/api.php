<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/geojson-points', [ApiController::class, 'points'])->name('geojson.points');
Route::get('/geojson-polylines', [ApiController::class, 'polylines'])->name('geojson.polylines');
Route::get('/geojson-polygons', [ApiController::class, 'polygons'])->name('geojson.polygons');
