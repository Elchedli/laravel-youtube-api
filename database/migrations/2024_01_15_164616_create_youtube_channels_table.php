<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYoutubeChannelsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('youtube_channels', function (Blueprint $table) {
            $table->string('channel_id')->primary(); // primary key
            $table->string('google_user_id'); // foreign key for the google user
            $table->json('channel_info'); //contains channel basic informations
            $table->json('videos_infoTable')->nullable(); //Contains channel videos informatons by type
            $table->json('analytics_info')->nullable(); //contain channel
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('youtube_channels');
    }
}
