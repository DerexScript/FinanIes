<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstNameMale(),
            'surname' => $this->faker->lastName(),
            'email' => 'admin@admin.com', //$this->faker->unique()->safeEmail(),
            'username' => 'admin', //$this->faker->unique()->userName(),
            'email_verified_at' => gmdate('Y-m-d H:i:s'),
            'is_admin' => 1,
            'password' => '$2y$10$0rb1CegyVWyNFjHmEr3tOetqVI8F2DvvTdynl83KnJqtZ67A529CO', // password123
            'role_id' => 1,
            'remember_token' => Str::random(10),
        ];
    }
}
