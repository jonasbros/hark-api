<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'display_name'    => $this->faker->unique()->userName(),
            'name'            => $this->faker->name(),
            'email'           => $this->faker->unique()->safeEmail(),
            'bio'             => $this->faker->sentence(),
            'websites'        => $this->faker->domainName(),
            'profile_picture' => $this->faker->url(),
            'cover_picture'   => $this->faker->url(),
            'password_hash'   => $this->faker->md5(),
            'user_type'       => 'user',
            'custom_url'      => $this->faker->unique()->userName(),
            'birthdate'       => $this->faker->date('Y-m-d', 'now'),
            'last_login'      => $this->faker->dateTime(),
        ];
    }
}
