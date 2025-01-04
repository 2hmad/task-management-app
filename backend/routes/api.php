<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['message' => 'Healthy'], 200);
});

// Tasks routes
Route::get('/tasks', [TaskController::class, 'getTasks']);
