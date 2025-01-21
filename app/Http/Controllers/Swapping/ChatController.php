<?php

namespace App\Http\Controllers\Swapping;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\Message;
use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index($chatRoomId)
    {
        // Find the chat room or fail
        $chatRoom = ChatRoom::findOrFail($chatRoomId);

        // Ensure the user is part of this chat room
        $userId = Auth::id();
        if ($chatRoom->bid->bidder_id !== $userId && $chatRoom->bid->receiver_id !== $userId) {
            abort(403, 'Unauthorized access to this chat room.');
        }

        // Check if the offer associated with the bid exists
        $offer = $chatRoom->bid->offer;
        if (!$offer) {
            // Delete all messages in the chat room
            $chatRoom->messages()->delete();
            // Delete the bid and the chat room
            $chatRoom->bid()->delete();
            $chatRoom->delete();

            abort(404, 'Offer not found.');
        }

        // Check if the bid status is 'pending'
        if ($chatRoom->bid->status === 'pending') {
            abort(404, 'Bid not accepted yet.');
        }

        // Fetch the names of the users in the chat room
        $senderName = $chatRoom->bid->bidder->name;
        $receiverName = $chatRoom->bid->receiver->name;

        // Fetch the messages in the chat room and reverse them to maintain original order
        $messages = $chatRoom->messages()->latest()->get()->reverse();

        // Pass the data to the view
        return view('chat.index', compact('messages', 'chatRoom', 'chatRoomId', 'senderName', 'receiverName', 'offer'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'chat_room_id' => 'required|exists:chat_rooms,id',
            'content' => 'required|string|max:1000'
        ]);

        $chatRoom = ChatRoom::findOrFail($request->chat_room_id);

        // Ensure the user is part of this chat room
        $userId = Auth::id();
        if ($chatRoom->bid->bidder_id !== $userId && $chatRoom->bid->receiver_id !== $userId) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        if ($chatRoom->status === 'closed') {
            Message::create([
                'chat_room_id' => $request->chat_room_id,
                'sender_id' => $userId,
                'content' => "<div class='alert alert-danger'>تم إغلاق هذه الغرفة من طرف أحد أعضائها</div>"
            ]);
        } else {
            Message::create([
                'chat_room_id' => $request->chat_room_id,
                'sender_id' => $userId,
                'content' => $request->content
            ]);
        }


        return redirect()->back()->with('success', 'Message sent successfully.');
    }

    public function getMessages($chatRoomId)
    {
        $chatRoom = ChatRoom::findOrFail($chatRoomId);

        // Ensure the user is part of this chat room
        $userId = Auth::id();
        if ($chatRoom->bid->bidder_id !== $userId && $chatRoom->bid->receiver_id !== $userId) {
            abort(404);
        }

        // Mark messages as seen by the authenticated user
        $chatRoom->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('seen_at')
            ->update(['seen_at' => now()]);

        // Retrieve and return messages
        $messages = $chatRoom->messages()->latest()->get();
        return response()->json($messages);
    }
    public function close($chatRoomId)
    {
        $chatRoom = ChatRoom::findOrFail($chatRoomId);

        // Ensure the user has permission to close the chat room
        $userId = Auth::id();
        if ($chatRoom->bid->bidder_id !== $userId && $chatRoom->bid->receiver_id !== $userId) {
            return redirect()->back()->with('error', 'Unauthorized access to close this chat room.');
        }
        $chatRoom->update(['status' => 'closed']);
        return redirect()->back()->with('success', 'Chat Room closed successfully.');
    }

    protected $appends = ['latest_activity'];

    public function getLatestActivityAttribute()
    {
        $created_at = $this->created_at;
        $updated_at = $this->updated_at;
        $latest_message_created_at = $this->messages->isNotEmpty() ? $this->messages->max('created_at') : null;
        $latest_message_seen_at = $this->messages->isNotEmpty() ? $this->messages->max('seen_at') : null;

        $dates = array_filter([$created_at, $updated_at, $latest_message_created_at, $latest_message_seen_at]);

        return !empty($dates) ? max($dates) : null;
    }
}
