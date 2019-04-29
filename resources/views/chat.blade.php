@extends('layouts.app')

@section('content')

    <div class="container chats">
        <div class="row" id="app">
            <div class="col-md-8 col-md-offset-2">
                <div class="card card-default">
                    <div class="list-group-item active">{{$room}}</div>
                    <div class="card-body" v-chat-scroll="{always: false, smooth: true}">
                        <chat-messages :messages="messages"></chat-messages>
                    </div>
                    <div class="card-footer">
                        <chat-form
                                @messagesent="addMessage"
                                room="{{$room}}"
                                :user="{{ auth()->user() }}"
                        ></chat-form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="list-group">
                    <li class="list-group-item active">Users</li>
                    <li class="list-group-item" v-for="user in users">
                        @{{ user.name }}
                    </li>
                </ul>
                <br>

                <ul class="list-group">
                    <li class="list-group-item active">Available rooms</li>
                    @foreach(App\Room::all() as $room)
                    <li class="list-group-item" >
                        <a href="/rooms/{{$room->room_name}}">{{$room->room_name}}</a>
                    </li>
                    @endforeach
                </ul>
                <ul class="list-group mt-5">
                    <li class="list-group-item active">Create new room</li>
                    <li class="list-group-item">
                        <form action="/newroom" method="POST" class="row">
                            {{ csrf_field() }}
                            <input type="text" class="form-control col-12"  placeholder="enter the room name"  name="room_name" >
                            <button class="btn btn-dark col-12 mt-3">Create</button>
                        </form>
                    </li>
                </ul>

            </div>
        </div>
    </div>
@endsection
