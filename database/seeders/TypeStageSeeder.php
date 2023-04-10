<?php

namespace Database\Seeders;

use App\Models\TypeStage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typeStage = [
            [
                'name' => 'Indagacion',
            ],
            [
                'name' => 'Imputacion',
            ],
            [
                'name' => 'Acusacion',
            ],
            [
                'name' => 'Preparatoria',
            ],
            [
                'name' => 'Audiencias orales',
            ],
            [
                'name' => 'Apelacion',
            ],
            [
                'name' => 'Condena',
            ],
        ];
        
        foreach ($typeStage as $type) {
            TypeStage::create($type);
        }
    }
}
