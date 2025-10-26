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
        // 1. Ubah enum kolom status terlebih dahulu
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected', 'finished', 'active', 'cancelled'])->default('active')->change();
        });

        // 2. Lalu update isi datanya
        DB::table('bookings')->whereIn('status', ['pending', 'approved'])->update(['status' => 'active']);
        DB::table('bookings')->where('status', 'rejected')->update(['status' => 'cancelled']);

        // 3. (Opsional) Bersihkan enum dari nilai lama — tapi ini hanya bisa dilakukan manual di level DB atau dengan raw SQL.
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected', 'finished'])->default('pending')->change();
        });

        DB::table('bookings')->where('status', 'active')->update(['status' => 'pending']);
        DB::table('bookings')->where('status', 'cancelled')->update(['status' => 'rejected']);
    }
};
