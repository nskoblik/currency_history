<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        //@TODO add indexes
        Schema::create('currency_history', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedSmallInteger('currency_code');
            $table->string('value');
            $table->integer('nominal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_history');
    }
};
