<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Permission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->text(5),
            'description' => $this->faker->text(10),
            "view" => $this->faker->boolean(50),
            "edit" => $this->faker->boolean(50),
            "delete" => $this->faker->boolean(50)
        ];
    }
}
