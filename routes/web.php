<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home route - redirect to Filament user panel
Route::get('/', function () {
    return redirect('welcome');
});

// Optional: Keep this for API or custom routes