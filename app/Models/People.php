<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'nit',
        'issue_nit',
        'num_ministry',
        'num_dispach',
        'radicated',
        'authority',
        'number',
        'type_people_id',
    ];

    public function typePeople()
    {
        return $this->belongsTo(TypePeople::class);
    }

    public function processes()
    {
        return $this->hasMany(Process::class);
    }
}
