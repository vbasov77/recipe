<?php

namespace App\Http\Controllers;


use App\Models\Message;
use App\Services\MessageService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{

    private $messageService;
    private $userService;

    /**
     * MessageController constructor.
     */
    public function __construct()
    {
        $this->messageService = new MessageService();
        $this->userService = new UserService();
    }


    public function view(Request $request)
    {

        $userId = Auth::id();

        // Получим все сообщения чата двух юзеров
        $messages = $this->messageService->findAllMessagesFrom2Users($request->to_user_id, $userId);


        if (!empty(count($messages))) {
            if ($messages[0]->from_user_id != Auth::id()) {
                $toUser = $messages[0]->from_user_id;
            } else {
                $toUser = $messages[0]->to_user_id;
            }
        } else {
            $toUser = $request->to_user_id;
        }

        // Изменяем статус сообщений
        $countMess = count($messages);
        for ($i = 0; $i < $countMess; $i++) {
            if ($messages[$i]->to_user_id == Auth::id() && $messages[$i]->status == 0) {
                Message::where('id', $messages[$i]->id)->update(['status' => 1]);
                $messages[$i]->status = 1;
            }
        }

        $app = $request->from_user_id;
        if ($request->from_user_id != Auth::user()->id) {
            $app = $request->to_user_id;
        }

        // Получим фото и имя собеседника
        $userAuthor = $this->userService->findById($app);

        return view('messages.show', [
            'userAuthor' => $userAuthor,
            'messages' => $messages,
            'userId' => $userId,
            'toUser' => $toUser,
        ]);
    }


    public function store(Request $request)
    {
        $message = [
            'from_user_id' => $request->from_user_id,
            'to_user_id' => $request->to_user_id,
            'body' => strip_tags($request->body),
        ];

        $id = $this->messageService->store($message);

        $date = $this->messageService->findCreatedAt($id);
        return response()->json([
            'bool' => true,
            'id' => $id,
            'body' => $request->body,
            'date' => $date
        ]);
    }


    public function myMessages(Request $request)
    {
//
    }


    public function destroy(Request $request)
    {
        $this->messageService->destroy($request->id);
        $res = ['answer' => 'ok'];

        exit(json_encode($res));
    }

    public function deleteChat(Request $request)
    {
        Message::where('from_user_id', $request->from_user_id)
            ->orWhere('to_user_id', $request->to_user_id)
            ->orWhere('from_user_id', $request->to_user_id)
            ->orWhere('to_user_id', $request->from_user_id)
            ->delete();
        $message = "Чат был удалён";

        return redirect()->action('MessageController@myMessages', ['message' => $message]);
    }

    public function checkNewMsg(Request $request)
    {
        $messages = Message::where('to_user_id', $request->from_user_id)
            ->where('from_user_id', $request->to_user_id)
            ->where('obj_id', $request->obj_id)->where('status', 0)->get();
        if (!empty(count($messages))) {
            $array = [];
            $countMess = count($messages);
            for ($i = 0; $i < $countMess; $i++) {
                Message::where('id', $messages[$i]->id)->update(['status' => 1]);
                $array[] = $messages[$i];
            }
            $result = ['bool' => true, 'messages' => $array];
            exit(json_encode($result));
        }
        return response()->json([
            'bool' => false,
        ]);

    }

}
