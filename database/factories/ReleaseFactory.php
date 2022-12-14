<?php

namespace Database\Factories;

use App\Models\Release;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReleaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Release::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text(5),
            'value' => $this->faker->randomFloat(2),
            "insert_date" => $this->faker->date('Y-m-d', 'now'),
            "voucher" => $this->faker->Image(),
            "type" => $this->faker->boolean(50)
        ];
    }
}
