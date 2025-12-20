<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionMemberController;

Route::get('/transactions', [TransactionMemberController::class, 'getRecentTransactions']);
Route::post('/transactions/update-payment', [TransactionMemberController::class, 'updatePayment']);