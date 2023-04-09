<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeopleStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'people_id',
        'stage_id',
    ];

    public function people()
    {
        return $this->belongsTo(People::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
