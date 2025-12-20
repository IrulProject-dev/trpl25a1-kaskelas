<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\TransactionMemberController;

Route::get('/', [LandingPageController::class, 'index']);

Route::get('/api/transactions', [TransactionMemberController::class, 'getRecentTransactions']);