<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    // Define o nome da tabela (opcional, pois o Laravel já assume 'applications' por convenção)
    protected $table = 'applications';

    // Atributos que podem ser preenchidos em massa
    protected $fillable = [
        'user_id',
        'course_id',
        'date_applied',
        'status'
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function opportunity()
{
    return $this->belongsTo(Course::class, 'course_id');
}

}