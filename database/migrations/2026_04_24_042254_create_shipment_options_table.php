<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shipment_options', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider'); // JNE, J&T, SiCepat, Antar Jemput
            $table->text('description')->nullable();
            $table->decimal('price', 12, 0)->default(0);
            $table->integer('estimated_days');
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipment_options');
    }
};
