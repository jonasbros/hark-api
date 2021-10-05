<?php

namespace Database\Factories;

use App\Models\UserPost;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserPostFactory extends Factory
{
    protected $model = UserPost::class;

    public function definition(): array
    {
    	return [
            'user_id'         => 5,
            'title'           => $this->faker->sentence(),
            'body'            => $this->faker->paragraph(),
            'featured_image'  => $this->faker->url(),
            'upload_url'      => $this->faker->url(),
            'post_type'       => 'base',
            'hashtags'        => 'tag1:tag2',
    	];
    }
}
