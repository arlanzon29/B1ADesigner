<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('itt1', function (Blueprint $table) {
            $table->string('Code', 50);
            $table->integer('LineId');
            $table->string('ItemCode', 50);
            $table->string('ItemName', 200);
            $table->decimal('Quantity', 10, 2)->default(1);
            $table->primary(['Code', 'LineId']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itt1');
    }
};