<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->regexify('[A-Z][0-9]{2}'),
            'floor' => $this->faker->numberBetween(0, 4),
            'available' => $this->faker->boolean,
            'long_contract' => $this->faker->boolean
        ];
    }
}
