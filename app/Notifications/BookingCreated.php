<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('📢 Booking Ruang Baru Telah Diajukan')
            ->greeting('Halo Admin 👋')
            ->line('Ada permintaan booking ruang baru dengan detail sebagai berikut:')
            ->line('Nama Pemesan: **' . $this->booking->nama . '**')
            ->line('Ruangan: **' . $this->booking->ruang->nama . '**')
            ->line('Tanggal: **' . \Carbon\Carbon::parse($this->booking->tanggal_booking)->translatedFormat('l, d F Y') . '**')
            ->line('Waktu: **' . $this->booking->jam_mulai . ' - ' . $this->booking->jam_selesai . '**')
            ->line('Jumlah Orang: **' . $this->booking->jumlah_orang . '**')
            ->line('Keperluan: **' . $this->booking->keperluan . '**')
            ->action('Lihat di Dashboard Admin', url('/admin/booking'))
            ->line('Terima kasih telah menggunakan sistem pemesanan ruang kami.')
            ->salutation('Salam hangat, 🌟');
    }
}
