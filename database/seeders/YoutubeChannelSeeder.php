<?php

namespace Database\Seeders;

use App\Models\Google\GoogleUser;
use App\Models\Google\YoutubeChannel;
use Illuminate\Database\Seeder;

class YoutubeChannelSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        YoutubeChannel::factory()
        ->count(2)
        ->create();
    }
}
