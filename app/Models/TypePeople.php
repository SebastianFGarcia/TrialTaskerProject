<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePeople extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function people()
    {
        return $this->hasMany(People::class);
    }
}
