<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oshp', function (Blueprint $table) {
            $table->string('Code', 50)->primary();
            $table->string('Name', 200);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oshp');
    }
};