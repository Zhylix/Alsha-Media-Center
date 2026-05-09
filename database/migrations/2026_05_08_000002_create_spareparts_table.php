<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('spareparts')) {
            // Table already exists (e.g. created manually or migration partially applied)
            // Keep migration idempotent.
            return;
        }

        Schema::create('spareparts', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('image')->nullable(); // path in storage/app/public/spareparts
            $table->text('description')->nullable();

            $table->decimal('price', 12, 0)->default(0);

            $table->foreignId('sparepart_category_id')
                ->constrained('sparepart_categories')
                ->cascadeOnDelete();

            $table->integer('stock')->default(0);

            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('spareparts');
    }
};

