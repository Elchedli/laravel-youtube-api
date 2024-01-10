<?php

namespace Database\Seeders;

use App\GoogleUser;
use Illuminate\Database\Seeder;

class GoogleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GoogleUser::factory()
            ->count(10)
            ->create();      
        //
    }
}