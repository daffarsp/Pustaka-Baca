<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'buku_id',
        'admin_pinjam_id',
        'admin_kembali_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'denda',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function adminPinjam()
    {
        return $this->belongsTo(User::class, 'admin_pinjam_id');
    }

    public function adminKembali()
    {
        return $this->belongsTo(User::class, 'admin_kembali_id');
    }

    // Helper Methods
    public function hitungDenda()
    {
        if ($this->status !== 'dikembalikan' || !$this->tanggal_kembali_aktual) {
            return 0;
        }

        $hariTerlambat = $this->tanggal_kembali_aktual->diffInDays($this->tanggal_kembali_rencana, false);
        
        if ($hariTerlambat < 0) {
            return abs($hariTerlambat) * 2000; // Denda Rp 2.000 per hari
        }

        return 0;
    }
}