<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'hanako.y@gmaol.com'],
            [
                'id' => 1,
                'name' => '山田 花子',
                'password' => Hash::make('hanako1234'),
            ],
        );
    }
}
