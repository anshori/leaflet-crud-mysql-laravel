<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// GeoJSON
Route::get('/geojson-points', [ApiController::class, 'points'])->name('geojson.points');
Route::get('/geojson-point/{id}', [ApiController::class, 'point'])->name('geojson.point');
Route::get('/geojson-polylines', [ApiController::class, 'polylines'])->name('geojson.polylines');
Route::get('/geojson-polyline/{id}', [ApiController::class, 'polyline'])->name('geojson.polyline');
Route::get('/geojson-polygons', [ApiController::class, 'polygons'])->name('geojson.polygons');
Route::get('/geojson-polygon/{id}', [ApiController::class, 'polygon'])->name('geojson.polygon');
