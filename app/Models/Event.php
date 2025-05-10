<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\EventStatus;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'date', 
        'time',
        'image',
        'active'
    ];
    //arrumar depos
    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i'
    ];

}
