<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crd1', function (Blueprint $table) {
            $table->string('CardCode', 50);
            $table->integer('LineId');
            $table->string('Address', 200);
            $table->primary(['CardCode', 'LineId']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crd1');
    }
};