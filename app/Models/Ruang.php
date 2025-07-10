<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'kapasitas',
        'jam_buka',
        'jam_tutup',
        'fasilitas',
        'lantai',
        'foto'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
