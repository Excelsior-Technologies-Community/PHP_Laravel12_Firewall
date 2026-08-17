<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirewallController;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/

Route::get('/info', function () {
    return view('welcome');
})->name('info');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('firewall')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('/dashboard', function () {
        return "
            <h1 style='text-align:center; margin-top:50px;'>
                🔒 Protected Dashboard Page
            </h1>

            <p style='text-align:center;'>
                You have access to this page because your IP is not blocked.
            </p>
        ";
    })->name('dashboard');

    Route::get('/admin', function () {
        return "
            <h1 style='text-align:center; margin-top:50px;'>
                👑 Admin Area
            </h1>

            <p style='text-align:center;'>
                Welcome to the protected admin section.
            </p>
        ";
    })->name('admin');
});

/*
|--------------------------------------------------------------------------
| Firewall Management
|--------------------------------------------------------------------------
*/

Route::get(
    '/firewall',
    [FirewallController::class, 'index']
)->name('firewall.index');

Route::post(
    '/firewall',
    [FirewallController::class, 'store']
)->name('firewall.store');

Route::delete(
    '/firewall/{id}',
    [FirewallController::class, 'destroy']
)->name('firewall.unblock');

Route::delete(
    '/firewall/{id}/delete',
    [FirewallController::class, 'delete']
)->name('firewall.delete');

/*
|--------------------------------------------------------------------------
| CSV Export
|--------------------------------------------------------------------------
*/

Route::get(
    '/firewall/export',
    [FirewallController::class, 'export']
)->name('firewall.export');
