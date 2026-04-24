<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('customer_address')->nullable();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('shipment_option_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('payment_method_id')->nullable()->constrained()->onDelete('set null');
            $table->text('device_description');
            $table->text('problem_description');
            $table->decimal('service_price', 12, 0);
            $table->decimal('shipment_price', 12, 0)->default(0);
            $table->decimal('total_price', 12, 0);
            $table->string('status')->default('pending'); // pending, confirmed, in_progress, completed, cancelled
            $table->string('payment_status')->default('unpaid'); // unpaid, paid, refunded
            $table->string('payment_proof')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
