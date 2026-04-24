<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('admins', 'username')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->string('username')->unique()->nullable()->after('name');
            });
        }

        $existing = DB::table('admins')->first();

        if ($existing) {
            DB::table('admins')->where('id', $existing->id)->update([
                'username'   => 'Admin',
                'password'   => Hash::make('admin123'),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('admins')->insert([
                'name'       => 'Administrator',
                'email'      => 'admin@techfixpro.com',
                'username'   => 'Admin',
                'password'   => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('admins', function (Blueprint $table) {
            $table->string('username')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('admins', 'username')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('username');
            });
        }
    }
};
