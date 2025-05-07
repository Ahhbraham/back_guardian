<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        // Manually create message (no model events/relations)
        $message = new Message();
        $message->sender_id = Auth::id();
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;
        $message->save();

        return response()->json(['status' => 'success', 'message_id' => $message->id], 201);
    }

    public function getMessages(Request $request)
    {
        $request->validate([
            'contactId' => 'required|exists:users,id',
        ]);

        // Raw query without model scopes/relations
        $messages = Message::where([
            ['sender_id', Auth::id()],
            ['receiver_id', $request->contactId],
        ])->orWhere([
            ['sender_id', $request->contactId],
            ['receiver_id', Auth::id()],
        ])->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }
}