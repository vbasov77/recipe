<?php


namespace App\Repositories;


use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class CommentRepository extends Repository
{
    public function addComment(array $comment)
    {
        return Comment::insertGetId($comment);
    }

    public function findAllById(int $id)
    {
        return DB::table('comments')->where('recipe_id', $id)
            ->leftJoin('users', 'comments.user_id', '=', 'users.id')
            ->orderBy('comments.created_at', 'desc')
            ->get(['name' => 'users.name', 'comments.*']);
    }

    public function destroy(int $id)
    {
        Comment::where('id', $id)->delete();
    }
}