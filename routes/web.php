<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\PolygonController;
use App\Http\Controllers\PolylineController;

Route::get('/', [MapController::class, 'index'])->name('/');

// Point
Route::get('/create-point', [PointController::class, 'create'])->name('point.create');
Route::post('/store-point', [PointController::class, 'store'])->name('point.store');
Route::get('/show-point/{id}', [PointController::class, 'show'])->name('point.show');
Route::get('/edit-point/{id}', [PointController::class, 'edit'])->name('point.edit');
Route::put('/update-point/{id}', [PointController::class, 'update'])->name('point.update');
Route::delete('/destroy-point/{id}', [PointController::class, 'destroy'])->name('point.destroy');

// Polyline
Route::get('/create-polyline', [PolylineController::class, 'create'])->name('polyline.create');
Route::post('/store-polyline', [PolylineController::class, 'store'])->name('polyline.store');
Route::get('/show-polyline/{id}', [PolylineController::class, 'show'])->name('polyline.show');
Route::get('/edit-polyline/{id}', [PolylineController::class, 'edit'])->name('polyline.edit');
Route::put('/update-polyline/{id}', [PolylineController::class, 'update'])->name('polyline.update');
Route::delete('/destroy-polyline/{id}', [PolylineController::class, 'destroy'])->name('polyline.destroy');

// Polygon
Route::get('/create-polygon', [PolygonController::class, 'create'])->name('polygon.create');
Route::post('/store-polygon', [PolygonController::class, 'store'])->name('polygon.store');
Route::get('/show-polygon/{id}', [PolygonController::class, 'show'])->name('polygon.show');
Route::get('/edit-polygon/{id}', [PolygonController::class, 'edit'])->name('polygon.edit');
Route::put('/update-polygon/{id}', [PolygonController::class, 'update'])->name('polygon.update');
Route::delete('/destroy-polygon/{id}', [PolygonController::class, 'destroy'])->name('polygon.destroy');