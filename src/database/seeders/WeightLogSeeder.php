<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WeightLog;
use Database\Factories\WeightLogFactory;
use Illuminate\Database\Seeder;

class WeightLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = 1;

        WeightLog::factory()->count(35)->create([
            'user_id' => $user_id,
        ]);
    }
}
