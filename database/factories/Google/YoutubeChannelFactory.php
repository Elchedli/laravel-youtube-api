<?php

namespace Database\Factories\Google;

use App\Models\Google\GoogleUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use stdClass;

class YoutubeChannelFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        
        return [
            'channel_id' => $this->faker->jobTitle(),
            'googleX_id' => GoogleUser::factory(),
            'channel_info' => $this->generateObject(1),
            'videos_infoTable' => $this->generateObject(2),
            'analytics_info' => $this->generateObject(3)
        ];
    }





    //this generate objects inside objects by depth
    private function generateObject(int $depth = 3) {
        
        $object = new stdClass();

        $numProperties = $this->faker->numberBetween(1, 5);

        for ($i = 0; $i < $numProperties; $i++) {
            $key = $this->faker->word;
            $value = $depth > 1 ? $this->generateObject($depth - 1) : $this->faker->word;

            $object->$key = $value;
        }

        return $object;
    }






    //This can be used for testing purposes
    private function testObject(){
        
        $username = $this->faker->userName();
        $userAgent = $this->faker->userAgent();
        return <<<EOD
        {
            "content": [
                {
                    "firstBlock": {
                        "SecondBlock1": [1, 2, 3],
                        "SecondBlock2": "$username"
                    },
                    "secondBlock": ["Uno", "doué", "Tri"]
                },
                {
                    "firstBlock": {
                        "SecondBlock1": [3, 2, 1],
                        "SecondBlock2": "$userAgent"
                    },
                    "secondBlock": ["Un", "Deux", "Trois"]
                }
            ],
            "Snippets": {
                "video": [
                    {
                        "Thumbnail": "url://Blablabla",
                        "IDK": [3, 3, 3, 3]
                    }
                ]
            }
        }
        EOD;
    }
}
