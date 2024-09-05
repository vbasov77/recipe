<?php


namespace App\Repositories;


use App\Models\User;

class UserRepository extends Repository
{
    public function findById(int $id)
    {
        return User::where('id', $id)->first();
    }


}