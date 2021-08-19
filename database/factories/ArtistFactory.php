<?php

namespace Database\Factories;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtistFactory extends Factory
{
    protected $model = Artist::class;

    public function definition(): array
    {
        return [
            'name'            => $this->faker->catchPhrase(),
            'bio'             => $this->faker->sentence(),
            'websites'        => $this->faker->domainName(),
            'profile_picture' => $this->faker->url(),
            'cover_picture'   => $this->faker->url(),
            'custom_url'      => $this->faker->unique()->userName(),
            'tags'            => 'tag1:tag2',
            'date_created'    => $this->faker->date('Y-m-d', 'now'),
        ];
    }
}
