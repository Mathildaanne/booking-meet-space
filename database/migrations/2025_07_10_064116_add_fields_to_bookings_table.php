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
        Schema::table('bookings', function (Blueprint $table) {
            // Rename kolom dulu
            $table->renameColumn('booking_date', 'tanggal_booking');
            $table->renameColumn('start_time', 'jam_mulai');
            $table->renameColumn('end_time', 'jam_selesai');
        });

        Schema::table('bookings', function (Blueprint $table) {
            // Tambahkan kolom setelah rename selesai
            $table->string('nama')->after('user_id');
            $table->integer('jumlah_orang')->after('nama');
            $table->text('keperluan')->nullable()->after('jam_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Hapus kolom tambahan
            $table->dropColumn(['nama', 'jumlah_orang', 'keperluan']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            // Rename kolom kembali ke asal
            $table->renameColumn('tanggal_booking', 'booking_date');
            $table->renameColumn('jam_mulai', 'start_time');
            $table->renameColumn('jam_selesai', 'end_time');
        });
    }
};
