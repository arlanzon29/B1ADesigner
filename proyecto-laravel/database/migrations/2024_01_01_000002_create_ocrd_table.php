<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ocrd', function (Blueprint $table) {
            $table->string('CardCode', 50)->primary();
            $table->string('CardName', 200);
            $table->string('CardType', 1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ocrd');
    }
};