<?php

namespace App\Http\Controllers;

use App\Models\TransactionMember;
use App\Models\Member;
use App\Models\Week;
use Illuminate\Http\Request;

class TransactionMemberController extends Controller
{
    public function getRecentTransactions()
    {
        $transactions = TransactionMember::with(['member', 'week'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'member_name' => $transaction->member->name ?? 'Unknown Member',
                    'week' => $transaction->week->name ?? 'Unknown Week',
                    'amount' => $transaction->amount,
                    'date' => $transaction->created_at->format('Y-m-d'),
                    'status' => 'Paid' // Assuming all transactions in this table are paid
                ];
            });

        return response()->json($transactions);
    }

    public function updatePayment(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'week_id' => 'required|exists:weeks,id',
            'amount' => 'required|numeric|min:0'
        ]);

        // Find or create the transaction member record
        $transactionMember = TransactionMember::firstOrCreate(
            [
                'member_id' => $request->member_id,
                'week_id' => $request->week_id,
            ],
            [
                'amount' => $request->amount,
            ]
        );

        // Update the amount if the record already exists
        if (!$transactionMember->wasRecentlyCreated) {
            $transactionMember->update(['amount' => $request->amount]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment updated successfully',
            'data' => $transactionMember->load(['member', 'week'])
        ]);
    }
}