<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
     protected $fillable = [
        "start",
        "end",
        "TypeSeance",
        "Typepayment",
        "paid",
        "user_id",
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
