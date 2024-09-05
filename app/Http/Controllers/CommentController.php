<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $commentService;

    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->commentService = new CommentService();
    }


    public function saveComment(Request $request)
    {
        // Добавление коммента
        $id = $this->commentService->addComment($request);

        $date = Comment::where('id', $id)->value('created_at');
        return response()->json([
            'bool' => true,
            'date' => $date,
            'id' => $id,
            'name' => Auth::user()->name,
        ]);
    }

    public function destroy(Request $request)
    {
        if (Auth::user()->isAuthor(Auth::id()) || Auth::user()->isAdmin()) {
            $this->commentService->destroy($request);
            $res = ['answer' => 'ok'];
        } else {
            $res = ['answer' => 'no'];
        }

        exit(json_encode($res));
    }


}
