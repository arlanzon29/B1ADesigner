<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owhs', function (Blueprint $table) {
            $table->string('WhsCode', 50)->primary();
            $table->string('WhsName', 200);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owhs');
    }
};