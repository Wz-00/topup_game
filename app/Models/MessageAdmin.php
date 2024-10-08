<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageAdmin extends Model
{
    use HasFactory;
    public function message(){
        $this->hasMany(Message::class,'request_id', 'request_id');
    }
    public function user(){
        $this->belongsTo(User::class);
    }
}
