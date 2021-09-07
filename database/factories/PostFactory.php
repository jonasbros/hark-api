<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
    	return [
            'user_id'         => 3,
            'title'           => $this->faker->sentence(),
            'body'            => $this->faker->paragraph(),
            'profile_picture' => $this->faker->url(),
            'cover_picture'   => $this->faker->url(),
            'custom_url'      => $this->faker->unique()->userName(),
            'tags'            => 'tag1:tag2',
            'date_created'    => $this->faker->date('Y-m-d', 'now'),
    	];

        // $table->bigInteger('user_id')->unsigned();
        // $table->string('title', 72);
        // $table->longText('body');
        // $table->string('upload_url', 512);
        // $table->string('featured_image', 512);
        // $table->string('hashtags', 128);
        // $table->string('post_type', 32);
        // $table->timestamps();
    }
}
