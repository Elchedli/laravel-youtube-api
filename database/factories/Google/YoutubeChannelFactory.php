<?php

namespace Database\Factories\Google;

use App\Models\Google\GoogleUser;
use App\Models\Google\YoutubeChannel;
use Illuminate\Database\Eloquent\Factories\Factory;
use stdClass;

class YoutubeChannelFactory extends Factory {

    /**
     * The name of the factory's corresponding model
     *
     * @var string
     */

    protected $model = YoutubeChannel::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() : array {

        return [
            'channel_id' => $this->faker->jobTitle(),
            'google_user_id' => GoogleUser::factory(),
            'channel_info' => $this->generateNestedObject(1),
            'videos_infoTable' => $this->generateNestedObject(2),
            'analytics_info' => $this->generateNestedObject(3)
        ];
    }



    //HACK Generate a nested stdClass object with a specified depth.
    private function generateNestedObject(int $depth = 3): stdClass {
        // Create a new stdClass object.
        $nestedObject = new stdClass();

        // Determine the number of properties for the object.
        $propertyCount = $this->faker->numberBetween(1, 5);

        // Generate properties for the object.
        for ($i = 0; $i < $propertyCount; $i++) {
            // Generate a random word for the property name.
            $propertyName = $this->faker->word;

            // If the current depth is greater than 1, generate a nested object for the property value.
            // Otherwise, generate a random word for the property value.
            $propertyValue = $depth > 1 ? $this->generateNestedObject($depth - 1) : $this->faker->word;

            // Assign the property value to the property name in the object.
            $nestedObject->$propertyName = $propertyValue;
        }

        // Return the generated object.
        return $nestedObject;
    }


    //HACK TThis can be used for testing purposes (unused function)
    private function testObject() {

        $username = $this->faker->userName();
        $userAgent = $this->faker->userAgent();

        //EOD is basically `` in javascript
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
