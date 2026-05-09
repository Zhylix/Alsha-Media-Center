<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sparepart_categories', function (Blueprint $table) {
            $table->id();

            // service_category examples: pc, laptop, printer, software
            $table->string('service_category');

            // part_type examples: RAM, SSD, VGA, Processor, Cartridge
            $table->string('part_type');

            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();

            $table->unique(['service_category', 'part_type'], 'sparepart_categories_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sparepart_categories');
    }
};

