<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if user already exists or create a new one
        $user = DB::table('users')->where('email', 'test@example.com')->first();
        if (!$user) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $userId = $user->id;
        }

        // Create a sample category for testing
        $categoryId = DB::table('categories')->insertGetId([
            'name' => 'Sample Category',
            'type' => 'income',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert sample transactions with valid types ('income' and 'expense')
        DB::table('transactions')->insert([
            [
                'user_id' => $userId,
                'category_id' => $categoryId,
                'description' => 'Sample income transaction',
                'amount' => 100000.00,
                'type' => 'income',
                'transaction_date' => now()->subDays(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'category_id' => $categoryId,
                'description' => 'Sample expense transaction',
                'amount' => 50000.00,
                'type' => 'expense',
                'transaction_date' => now()->subDays(2),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'category_id' => $categoryId,
                'description' => 'Another sample income',
                'amount' => 250000.00,
                'type' => 'income',
                'transaction_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
