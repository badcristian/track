<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\StopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', fn() => inertia('Dashboard/Index'))
        ->name('dashboard.index');

    Route::get('/stats', fn() => inertia('Dashboard/Index'))
        ->name('stats');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::resource('shipments', ShipmentController::class);

    Route::middleware('can:alter-shipment,shipment')
        ->resource('shipments.stops', StopController::class)->names([
            'store' => 'stops.store',
            'update' => 'stops.update',
            'destroy' => 'stops.destroy'
        ])->only(['store', 'update', 'destroy']);

    Route::middleware('can:alter-members,shipment')->group(function () {

        Route::get('/shipments/{shipment}/members', [MemberController::class, 'index'])
            ->name('members.search');

        Route::post('/shipments/{shipment}/members', [MemberController::class, 'store'])
            ->name('members.store');

        Route::delete('/shipments/{shipment}/members', [MemberController::class, 'destroy'])
            ->name('members.destroy');
    });

    Route::middleware('can:alter-shipment,shipment')->group(function () {

        Route::post('/shipments/{shipment}/comments', [CommentController::class, 'update'])
            ->name('comments.update');

        Route::post('/shipments/{shipment}/comments', [CommentController::class, 'destroy'])
            ->name('comments.destroy');

        Route::post('shipments//{shipment}/comments', [CommentController::class, 'store'])
            ->name('comments.store');
    });
});

require __DIR__ . '/auth.php';
