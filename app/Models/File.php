<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'stage_id'
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
