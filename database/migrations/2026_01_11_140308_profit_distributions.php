<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
      public function up(): void
    {
        Schema::create('profit_distributions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->unsignedInteger('year');
            $table->decimal('total_contribution', 12, 2);
            $table->decimal('profit_amount', 12, 2);
            $table->timestamp('distributed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'year']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profit_distributions');
    }
};
