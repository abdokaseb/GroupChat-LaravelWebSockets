<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Message;
use App\Room;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function createRoom(Request $data)
    {
       $room= new Room();
       $room->room_name=$data->get('room_name');
       if(Room::where('room_name',$data->get('room_name'))->first()== null) {
           $room->save();
       }
       else{
           $room= Room::where('room_name',$data->get('room_name'))->first();
       }
       return redirect("/rooms/".$room->room_name);
    }

    public function show($name){

        $room=Room::where('room_name',$name)->first();
        if($name=='general'){
            $room= new Room();
            $room->room_name='general';
            if(Room::where('room_name','general')->first()== null) {
                $room->save();
            }
        }
        if($room==null){
           return redirect("/notfound");
       }

        return view('chat')->with(['room'=>$room->room_name,'roomto'=>$name]);
    }

    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        $room = $request->room;
        $message = auth()->user()->messages()->create([
            'message' => $request->message,
            'roomChannel' => $room
        ]);
		broadcast(new MessageSent(auth()->user(), $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
