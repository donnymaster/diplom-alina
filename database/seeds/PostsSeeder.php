<?php

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = [
            'Викладач',
            'Старший викладач',
            'Доцент',
            'Професор',
            'Декан',
            'Проректор',
            'Ректор'
        ];

        foreach($posts as $post){
            Post::create([
                'post_name' => $post
            ]);
        }
    }
}
