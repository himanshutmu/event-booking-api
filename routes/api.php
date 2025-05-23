<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\AttendeeController;
use App\Http\Controllers\API\BookingController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('events', EventController::class);

Route::post('attendees', [AttendeeController::class, 'store']);
Route::post('bookings', [BookingController::class, 'store']);
