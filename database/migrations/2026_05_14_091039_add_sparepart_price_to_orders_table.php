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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'sparepart_price')) {
                $table->decimal('sparepart_price', 12, 0)->default(0)->after('shipment_price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'sparepart_price')) {
                $table->dropColumn('sparepart_price');
            }
        });
    }
};
