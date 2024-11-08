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
        Schema::create('target_adoptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_id')->constrained();
            $table->foreignId('adopting_mda_id')->constrained('mdas');
            $table->foreignId('original_mda_id')->constrained('mdas');
            $table->string('status');
            $table->text('reason_for_change')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_adoptions');
    }
};
