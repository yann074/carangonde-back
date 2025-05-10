<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'instructor',
        'start_date', 
        'end_date',
        'location',
        'image',
        'pdf',
        'slots',
        'active'
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'active' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
