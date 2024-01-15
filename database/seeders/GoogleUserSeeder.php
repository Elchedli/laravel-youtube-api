<?php

namespace Database\Seeders;

use App\Models\Google\GoogleUser;
use Illuminate\Database\Seeder;

class GoogleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        GoogleUser::factory()
            ->count(10)
            ->create();
    }
}
