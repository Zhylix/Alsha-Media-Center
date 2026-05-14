<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pakets', function (Blueprint $table) {
            if (!Schema::hasColumn('pakets', 'price')) {
                $table->decimal('price', 12, 0)->default(0)->after('discount_info');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pakets', function (Blueprint $table) {
            if (Schema::hasColumn('pakets', 'price')) {
                $table->dropColumn('price');
            }
        });
    }
};

