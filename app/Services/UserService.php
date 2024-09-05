<?php


namespace App\Services;


use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserService extends Service
{
    private $userRepository;


    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function findById(int $id)
    {
        return $this->userRepository->findById($id);
    }

}