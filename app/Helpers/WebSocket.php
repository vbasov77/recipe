<?php


namespace App\Helpers;


use App\Services\MessageService;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class WebSocket implements MessageComponentInterface
{
    protected $clients;

    private $rooms;

    private $user;


    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $msg = json_decode($msg);

        $this->rooms[$msg->room][$from->resourceId] = $from;
        $this->user[$from->resourceId] = $msg->room;

        $room = $this->user[$from->resourceId];
        $messageService = new MessageService();

        $message = [
            'from_user_id' => $msg->from_user_id,
            'to_user_id' => $msg->to_user_id,
            'body' => strip_tags($msg->body),
        ];

        $id = $messageService->store($message);
        $date = $messageService->findCreatedAt($id);

        $response = [
            'bool' => true,
            'id' => $id,
            'body' => $msg->body,
            'date' => $date
        ];


        foreach ($this->rooms[$room] as $client) {
            $client->send(json_encode($response));
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        $room = $this->user[$conn->resourceId];
        unset($this->rooms[$room][$conn->resourceId]);
        unset($this->users[$conn->resourceId]);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}