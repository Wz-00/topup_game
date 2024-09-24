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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_transaksi');
            $table->string('id_game');
            $table->foreignId('user_id')->nullable();
            $table->foreignId('payment_id')->constrained('payments');
            $table->foreignId('game_id')->constrained('games');
            $table->foreignId('item_id');
            $table->integer('Wa_Number');
            $table->string('status')->default('Menunggu Pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
