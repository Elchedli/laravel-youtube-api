<?php

namespace Database\Seeders;

use App\Models\Google\GoogleUser;
use Illuminate\Database\Seeder;

class GoogleUserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        // GoogleUser::factory()
        //     ->count(10)
        //     ->create();
        GoogleUser::factory()
        ->count(1)
        ->hasYoutubeChannels(1)
        ->create();

        GoogleUser::factory()
        ->count(2)
        ->hasYoutubeChannels(2)
        ->create();
    }
}
