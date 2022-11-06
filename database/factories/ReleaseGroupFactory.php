<?php

namespace Database\Factories;

use App\Models\ReleaseGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReleaseGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReleaseGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(5),
            'description' => $this->faker->text(15),
            "status" => $this->faker->boolean(50),
            'expiration' => $this->faker->date('Y-m-d', 'now')
        ];
    }
}
