<?php

namespace Database\Seeders;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('posts')->insert([
            'title' => 'Very captiviting article ',
            'slug' => 'very-captiviting-article ',
            'user_id'=>2,
            'sticky'=>1,
            'category_id'=>2,
            'body_short' => 'lorem ipsum',
            'blockquote' => 'And then she jumped into the endless abyss',
            'active'=>1,
            'body_long' => 'lorem ipsum lorem ipsum lorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsum lorem ipsum',
            'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=>Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        Post::factory()->count(50)->create();

    }
}
