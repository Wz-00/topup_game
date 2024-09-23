<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    // Override function boot
    // Override function boot
    protected static function boot()
    {
        parent::boot();

        // Event creating untuk generate custom ID Transaksi
        static::creating(function ($model) {
            $model->id_transaksi = static::generateIdTransaksi();
        });
    }

    // Function untuk generate id_transaksi
    private static function generateIdTransaksi()
    {
        // Ambil tanggal saat ini
        $date = date('Ymd');

        // Hitung jumlah transaksi yang sudah ada pada tanggal ini
        $count = static::whereDate('created_at', date('Y-m-d'))->count() + 1;

        // Format count menjadi 3 digit dengan padding
        $countPadded = str_pad($count, 3, '0', STR_PAD_LEFT);

        // Gabungkan tanggal dengan count
        return $date . $countPadded;
    }
    public function game(){
        return $this->belongsTo(Game::class);
    }
    public function payment(){
        return $this->belongsTo(Payment::class);
    }
    public function item(){
        return $this->belongsTo(Item::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
