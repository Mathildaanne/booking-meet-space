<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingCanceled extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

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
            ->subject('Booking Anda Telah Ditolak')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Booking Anda untuk ruangan: ' . $this->booking->ruang->nama)
            ->line('Tanggal: ' . $this->booking->tanggal_booking)
            ->line('Jam: ' . $this->booking->jam_mulai . ' - ' . $this->booking->jam_selesai)
            ->line('Status: Ditolak oleh Admin')
            ->line('Alasan: ' . $this->booking->alasan_pembatalan)
            ->line('Silakan hubungi admin jika ada pertanyaan lebih lanjut.')
            ->salutation('Terima kasih.');
    }
}
