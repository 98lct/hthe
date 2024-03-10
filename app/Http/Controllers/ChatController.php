<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Events\NotificationPublished;

class ChatController extends Controller
{
    protected $userID, $friendsList;

    public function __construct()
    {
        $this->middleware('jwt.verify');
        $this->userID = auth('api')->user()->user_id;
    }

    public function loadChat($userID, Request $request) {
        try {
            // get 10 latest chat messages gần thời gian hiện tại nhất

            



            $chat = Chat::where('senderID', $this->userID)
                ->where('receiverID', $userID)
                ->orWhere('senderID', $userID)
                ->where('receiverID', $this->userID)
                ->orderBy('send_time', 'desc')
                ->with('sender')
                ->with('receiver')
                ->limit(10)
                ->get();
                // get 10 latest chat messages 
            return response()->json([
                'status' => 200,
                'messages' => $chat
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    //sendChat
    public function sendChat($userID, Request $request) {
        try {
            $chat = new Chat();
            $chat->senderID = $this->userID;
            $chat->receiverID = $userID;
            $chat->content = $request->message;
            // lưu đủ thời gian

            $chat->send_time = \Carbon\Carbon::now('Asia/Ho_Chi_Minh');

            // $chat->send_time = now();

            $chat->save();
            // lấy 1 tin nhắn vừa gửi
            $chat = Chat::where('senderID', $this->userID)
                ->where('receiverID', $userID)
                ->orWhere('senderID', $userID)
                ->where('receiverID', $this->userID)
                ->orderBy('send_time', 'desc')
                ->with('sender')
                ->with('receiver')
                ->first();

            broadcast(new NotificationPublished('Bạn có tin nhắn mới', $userID, $chat));
       
            return response()->json([
                'status' => 200,
                'messages' => $chat
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
