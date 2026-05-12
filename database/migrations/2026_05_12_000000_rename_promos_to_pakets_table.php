<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Rename promos table to pakets
        Schema::rename('promos', 'pakets');
    }

    public function down(): void
    {
        // Rename pakets table back to promos
        Schema::rename('pakets', 'promos');
    }
};
