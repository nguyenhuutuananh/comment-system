<?php

use Illuminate\Database\Seeder;
use App\Comment;
use App\Post;
use App\User;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parentComment = new Comment();
        $parentComment->user()->associate(User::first());
        $parentComment->content = 'test';
        $parentComment->commentable()->associate(Post::first());
        $parentComment->save();

        $comment = new Comment();
        $comment->user()->associate(User::first());
        $comment->content = 'test test test';
        $comment->parent()->associate($parentComment);
        $comment->commentable()->associate(Post::first());
        $comment->save();
    }
}
