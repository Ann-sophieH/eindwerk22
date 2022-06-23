<?php

namespace Database\Seeders;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('comments')->insert([
            'body' => 'test hoofdcomments moet als eerste staan purple heart lorem',
            'is_active'=> 1,
            'post_id'=> 1,
            'user_id'=> 1,
            'parent_id'=> NULL,
            'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=>Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('comments')->insert([
            'body' => 'test hoofdcomments moet als eerste staan purple heart lorem',
            'is_active'=> 1,
            'post_id'=> 2,
            'user_id'=> 5,
            'parent_id'=> NULL,
            'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=>Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('comments')->insert([
            'body' => 'test hoofdcomments moet als eerste staan purple heart lorem',
            'is_active'=> 1,
            'post_id'=> 5,
            'user_id'=> 10,
            'parent_id'=> NULL,
            'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=>Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('comments')->insert([
            'body' => 'test hoofdcomments moet als eerste staan purple heart lorem',
            'is_active'=> 1,
            'post_id'=> 3,
            'user_id'=> 8,
            'parent_id'=> NULL,
            'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=>Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('comments')->insert([
            'body' => 'test hoofdcomments moet als eerste staan purple heart lorem',
            'is_active'=> 1,
            'post_id'=> 6,
            'user_id'=> 34,
            'parent_id'=> NULL,
            'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=>Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('comments')->insert([
            'body' => 'test hoofdcomments moet als eerste staan purple heart lorem',
            'is_active'=> 1,
            'post_id'=> 2,
            'user_id'=> 2,
            'parent_id'=> NULL,
            'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=>Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        Comment::factory()->count(50)->create();

    }
}
