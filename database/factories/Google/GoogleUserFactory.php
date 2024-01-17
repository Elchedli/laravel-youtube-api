<?php

namespace Database\Factories\Google;

use App\Models\Google\GoogleUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;

class GoogleUserFactory extends Factory {

    /**
     * The name of the factory's corresponding model
     *
     * @var string
     */

    protected $model = GoogleUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array {

        return [
            'google_id' => $this->faker->phoneNumber(),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'thumbnailURL' => $this->getRedirectedUrl(),
            'refreshToken' => $this->faker->bankAccountNumber()
        ];
    }


    // This function get the redirected url for this specific website
    private function getRedirectedUrl(): string {
        
        $originalUrl = 'https://source.unsplash.com/random/800x600';
        $response = (object) Http::get($originalUrl);
        $img = $response->transferStats->getHandlerStats()['url'];
        
        return $img;
    }
}
