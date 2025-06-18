<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckinController;

Route::post('/checkin', [CheckinController::class, 'checkin']);
