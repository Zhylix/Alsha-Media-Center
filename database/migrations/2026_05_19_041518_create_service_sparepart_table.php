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
        Schema::create('service_sparepart', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnDelete();

            $table->foreignId('sparepart_id')
                ->constrained('spareparts')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['service_id', 'sparepart_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_sparepart');
    }
};

