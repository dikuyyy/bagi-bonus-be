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
        Schema::create('bagi_bonus_item', function (Blueprint $table) {
            $table->id();
            $table->integer('bagi_bonus_id');
            $table->string('nama');
            $table->bigInteger('total_pembayaran');
            $table->integer('total_persentase');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bagi_bonus_item');
    }
};
