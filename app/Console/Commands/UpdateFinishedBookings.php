<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;

class UpdateFinishedBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:update-finished';
    protected $description = 'Update status booking yang sudah lewat menjadi finished';

    public function handle()
    {
        $now = Carbon::now('Asia/Jakarta');

        $updated = Booking::where('status', 'active')
            ->where(function ($query) use ($now) {
                $query->where('tanggal_booking', '<', $now->toDateString())
                    ->orWhere(function ($q) use ($now) {
                        $q->where('tanggal_booking', $now->toDateString())
                            ->where('jam_selesai', '<', $now->format('H:i:s'));
                    });
            })
            ->update(['status' => 'finished']);

        $this->info("Status $updated booking diubah menjadi finished.");
    }

}
