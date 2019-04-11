<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Message;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function newRoom(Request $request){
        $room = $request->room;
        echo $room;
        Broadcast::channel($room, function ($user) {
            return $user;
        });

        return ['status' => 'Message Sent!'];
    }

    public function index(Request $request)
    {
        $room = $request->room;
        if ($room == NULL){
            $room = 'chat';
        }
        echo $room;
        return view('chat')->with(['room'=>$room]);
    }

    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        $message = auth()->user()->messages()->create([
            'message' => $request->message
        ]);
        $room = $request->room;
        // String $room = ;
        // console.log("i'm here");
		broadcast(new MessageSent(auth()->user(), $message,$room))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
