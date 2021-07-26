<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Cliente;
use App\User;
class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {   $user = auth()->user();
        $users = User::all();
       $message = Message::where('doc_id',$id)->get();
       $cliente = Cliente::all();
        return view('livewire.chat-room',compact('message','cliente','user','users'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        return [
            'message' => $message,
            'user' => $user,
        ];
    }
}
