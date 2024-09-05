<?php


namespace App\Services;


use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

class CommentService extends Service
{
    private $commentRepository;


    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
    }


    public function addComment(Request $request)
    {
        $comment = [
            'user_id' => $request->user_id,
            'recipe_id' => $request->recipe_id,
            'comment_text' => $request->comment
        ];
        return $this->commentRepository->addComment($comment);
    }

    public function findAllById(int $id)
    {
        return $this->commentRepository->findAllById($id);
    }

    public function destroy(Request $request)
    {
        $this->commentRepository->destroy($request->id);
    }

}