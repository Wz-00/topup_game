<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->request_id = static::generateRequestID();
        });
    }

    private static function generateRequestID()
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

    public function messageadmin(){
        $this->belongsTo(MessageAdmin::class, 'request_id', 'request_id');
    }
    public function user(){
        $this->belongsTo(User::class);
    }

}
