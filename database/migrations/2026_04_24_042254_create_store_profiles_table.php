<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('store_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->text('tagline')->nullable();
            $table->text('description');
            $table->string('address');
            $table->string('city');
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('email');
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->decimal('latitude', 10, 7)->default(-6.9147440);
            $table->decimal('longitude', 10, 7)->default(107.6098100);
            $table->string('open_hours')->default('08:00 - 20:00');
            $table->string('open_days')->default('Senin - Sabtu');
            $table->string('logo')->nullable();
            $table->string('hero_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_profiles');
    }
};
