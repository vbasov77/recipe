<?php


namespace App\Repositories;

use App\Models\Message;
use Illuminate\Support\Facades\DB;

class MessageRepository extends Repository
{
    public function findAllMessagesFrom2Users(int $toUserId, int $authUser)
    {
        return DB::select('select m.* from messages m where
(from_user_id= ' . $toUserId . ' and to_user_id = ' . $authUser . ')
or
(from_user_id = ' . $authUser . ' and to_user_id = ' . $toUserId . ');');
    }

    public function store($message)
    {
        return Message::insertGetId($message);
    }

    public function findCreatedAt(int $id)
    {
        return Message::where('id', $id)->value('created_at');
    }

    public function destroy(int $id)
    {
        Message::where('id', $id)->delete();
    }

}