<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\ApiController;
// use App\Http\Controllers\BlogController;

// Route::post('/register', [ApiController::class, 'register']);
// Route::post('/login', [ApiController::class, 'login']);

// Route::group(['middleware' => ['auth:sanctum']], function () {

//     Route::get('/profile', [ApiController::class, 'profile']);
//     Route::get('/logout', [ApiController::class, 'logout']);

//     // Route::resource('blog', BlogController::class);

//     Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
//     Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');
//     Route::put('/blog/{blog}', [BlogController::class, 'update'])->name('blog.update');
//     Route::delete('/blog/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy');



// });


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

use App\Http\Controllers\EventController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['web', 'auth.session'])->group(function () {
    Route::apiResource('tasks', TaskController::class);

    Route::apiResource('events', EventController::class);
});

// routes/api.php
//oute::get('/events/upcoming', [EventController::class, 'upcomingEvents']);




