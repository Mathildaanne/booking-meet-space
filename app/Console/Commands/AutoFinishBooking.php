<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking
;
class AutoFinishBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:autofinish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Otomatis mengubah status booking menjadi finished jika sudah melewati jam_selesai';


    public function handle()
    {
        \App\Models\Booking::where('status', 'approved')
        ->whereDate('tanggal_booking', '<=', now()->toDateString())
        ->whereTime('jam_selesai', '<=', now()->toTimeString())
        ->update(['status' => 'finished']);
        $this->info('Auto update booking finished.');
    }
}
