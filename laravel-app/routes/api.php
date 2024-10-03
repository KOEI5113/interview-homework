<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::resource("order", OrderController::class)->except(["destroy", "update", 'create', 'index']);