<?php


namespace App\Services;


use App\Repositories\MessageRepository;

class MessageService extends Service
{
    private $messageRepository;

    public function __construct()
    {
        $this->messageRepository = new MessageRepository();
    }

    public function findAllMessagesFrom2Users(int $toUserId, int $authUser)
    {
        return $this->messageRepository->findAllMessagesFrom2Users($toUserId, $authUser);
    }

    public function store(array $message)
    {
        return $this->messageRepository->store($message);
    }

    public function findCreatedAt(int $id)
    {
        return $this->messageRepository->findCreatedAt($id);
    }

    public function destroy(int $id)
    {
        $this->messageRepository->destroy($id);
    }

}