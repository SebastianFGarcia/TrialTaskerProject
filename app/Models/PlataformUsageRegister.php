<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlataformUsageRegister extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'users_count',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

}
