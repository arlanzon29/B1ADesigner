<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oitm', function (Blueprint $table) {
            $table->string('ItemCode', 50)->primary();
            $table->string('ItemName', 200);
            $table->decimal('OnHand', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oitm');
    }
};