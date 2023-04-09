<?php

namespace Database\Seeders;

use App\Models\TypePeople;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypePeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typePeople = [
            [
                'name' => 'Cliente',
            ],
            [
                'name' => 'Juez de Paz',
            ],
            [
                'name' => 'Juez de Familia',
            ],
            [
                'name' => 'Juez de Ejecución Penal',
            ],
            [
                'name' => 'Juez de Ejecución Civil',
            ],
            [
                'name' => 'Juez de Ejecución Laboral',
            ],
        ];
        
        foreach ($typePeople as $type) {
            TypePeople::create($type);
        }
    }
}
