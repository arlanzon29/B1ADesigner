<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oige', function (Blueprint $table) {
            $table->string('Code', 50)->primary();
            $table->date('DocDate');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oige');
    }
};