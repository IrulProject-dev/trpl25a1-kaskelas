<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique(); // Identifikasi Utama
            $table->string('name');
            $table->string('batch')->nullable(); // Angkatan (Opsional)
            $table->timestamps();
        });

        Schema::create('weeks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "Januari Minggu 1"
            $table->date('start_date');
            $table->decimal('nominal', 10, 2)->default(5000); // Default tagihan 5000
            $table->timestamps();
        });

        Schema::create('transaction_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('week_id')->constrained('weeks')->onDelete('cascade');
            $table->decimal('amount', 10, 2); // Jumlah yang dibayar
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_members');
        Schema::dropIfExists('weeks');
        Schema::dropIfExists('members');
    }
};
