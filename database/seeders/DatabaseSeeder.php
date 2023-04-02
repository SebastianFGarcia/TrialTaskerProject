<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\PlataformUsageRegister;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(20)->create();

        \App\Models\User::factory()->create([
            'email' => 'test@example.com',
        ]);

        // crea registros de una semana hasta hoy para la tabla PlataformUsageRegister
        $start = Carbon::now()->subDays(7)->format('Y-m-d');
        $end = Carbon::now()->format('Y-m-d');
        
        for ($date = $start; $date <= $end; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
            PlataformUsageRegister::create([
                'date' => $date,
                'users_count' => rand(0, 100),
            ]);
        }
    }
}
