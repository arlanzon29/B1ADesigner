<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ige1', function (Blueprint $table) {
            $table->string('Code', 50);
            $table->integer('LineId');
            $table->string('ItemCode', 50);
            $table->string('Dscripcion', 200);
            $table->decimal('Quantity', 10, 2);
            $table->string('WhsCode', 50);
            $table->primary(['Code', 'LineId']);
            $table->foreign('Code')->references('Code')->on('oige')->onDelete('cascade');
            $table->foreign('ItemCode')->references('ItemCode')->on('oitm')->onDelete('restrict');
            $table->foreign('WhsCode')->references('WhsCode')->on('owhs')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ige1');
    }
};