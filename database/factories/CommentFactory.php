<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users = User::pluck('id')->toArray();
        $posts = Post::pluck('id')->toArray();

        return [
            //
            'body'=>$this->faker->realText(200, 2),
            'parent_id'=>$this->faker->numberBetween(1, 5),
            'user_id'=>$this->faker->randomElement($users),
            'post_id'=>$this->faker->randomElement($posts),
            'is_active'=>$this->faker->numberBetween(0, 1),
        ];
    }
}
