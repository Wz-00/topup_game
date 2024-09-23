<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function item(){
        return $this->hasMany(Item::class);
    }
    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
    public function banner(){
        return $this->hasMany(Banner::class);
    }
}
