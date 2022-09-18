<?php

namespace Database\Factories;

use App\Models\Entry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Entry::class;

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
            "date" => $this->faker->date('Y-m-d', 'now'),
            "voucher" => $this->faker->Image(),
            "status" => $this->faker->boolean(50)
        ];
    }
}
