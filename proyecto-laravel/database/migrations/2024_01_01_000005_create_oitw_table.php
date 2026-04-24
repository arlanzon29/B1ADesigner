<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oitw', function (Blueprint $table) {
            $table->string('ItemCode', 50);
            $table->string('WhsCode', 50);
            $table->double('OnHand')->default(0);
            $table->primary(['ItemCode', 'WhsCode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oitw');
    }
};