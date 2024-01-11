<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;

class GoogleUserFactory extends Factory
{

    /**
     * The name of the factory's corresponding model
     *
     * @var string
     */
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {


        return [
            'id' => $this->faker->phoneNumber(),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'thumbnailURL' => $this->getRedirectedUrl(),
            'refreshToken' => $this->faker->bankAccountNumber()
        ];
    }


    private function getRedirectedUrl() : string
    {
        $originalUrl = 'https://source.unsplash.com/random/800x600';
        $response = (object) Http::get($originalUrl);
        $img = $response->transferStats->getHandlerStats()['url'];
        return $img;
    }
}




