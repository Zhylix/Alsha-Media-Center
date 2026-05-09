<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // If table already exists, ensure columns align with expected schema.
        if (!Schema::hasTable('spareparts')) {
            return;
        }

        Schema::table('spareparts', function (Blueprint $table) {
            if (!Schema::hasColumn('spareparts', 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('spareparts', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('spareparts', 'price')) {
                $table->decimal('price', 12, 0)->default(0);
            }
            if (!Schema::hasColumn('spareparts', 'sparepart_category_id')) {
                $table->foreignId('sparepart_category_id')->nullable();
            }
            if (!Schema::hasColumn('spareparts', 'stock')) {
                $table->integer('stock')->default(0);
            }
            if (!Schema::hasColumn('spareparts', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
            if (!Schema::hasColumn('spareparts', 'sort_order')) {
                $table->integer('sort_order')->default(0);
            }
        });
    }

    public function down(): void
    {
        // no-op
    }
};

