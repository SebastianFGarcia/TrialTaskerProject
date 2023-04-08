<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'procedure_date',
        'is_active',
        'process_id',
        'type_stage_id',
    ];

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function typeStage()
    {
        return $this->belongsTo(TypeStage::class);
    }
}
