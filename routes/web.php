<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home route - redirect to user panel
Route::get('/', function () {
    return redirect('/user');
});

// Health check route (for monitoring)
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now(),
        'app_name' => config('app.name'),
    ]);
});

// Clear cache routes (admin only - remove in production)
Route::middleware(['auth'])->group(function () {
    Route::get('/clear-cache', function () {
        Artisan::call('optimize:clear');
        return 'Cache cleared successfully!';
    })->name('clear.cache');
});

// Fallback route for 404 errors
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});