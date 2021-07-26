<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatRoom extends Controller
{
    public function index(){
        return view('livewire.chat-room');
    }
}
