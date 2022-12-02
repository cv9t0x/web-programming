<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BindingsController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return Auth::check() ? redirect('/app/main') : redirect('/auth/login');
});

Route::prefix('app')->middleware('auth')->group(function () {
    Route::prefix('main')->group(function () {
        Route::get('/', [UserController::class, 'render_main']);

        Route::post('/edit', [UserController::class, 'edit_user']);
    });

    Route::prefix('bindings')->group(function () {
        Route::get('/', [BindingsController::class, 'render_bindings'])->name('pages.bindings');

        Route::post('/create', [BindingsController::class, 'create_binding'])->name('bindings.create');

        Route::post('/edit/{id}', [BindingsController::class, 'edit_binding'])->name('bindings.edit');

        Route::post('/remove/{id}', [BindingsController::class, 'remove_binding'])->name('bindings.remove');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/', [UserSettingsController::class, 'render_settings']);

        Route::post('/edit', [UserSettingsController::class, 'edit_user_settings']);
    });
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'render_login'])->name('auth.login');

    Route::get('/register', [AuthController::class, 'render_register'])->name('auth.register');

    Route::post('/login', [AuthController::class, 'authentificate']);

    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
