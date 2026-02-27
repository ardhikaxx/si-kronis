<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        $conversations = Message::where(function($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
        })
        ->with(['sender', 'receiver'])
        ->get()
        ->groupBy(function($message) use ($userId) {
            return $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
        })
        ->map(function($messages) use ($userId) {
            $otherUser = $messages->first()->sender_id === $userId 
                ? $messages->first()->receiver 
                : $messages->first()->sender;
            
            return [
                'user' => $otherUser,
                'last_message' => $messages->last()->message,
                'last_time' => $messages->max('created_at'),
                'unread' => $messages->where('receiver_id', $userId)->where('is_read', false)->count(),
            ];
        })
        ->sortByDesc('last_time')
        ->values();

        return view('dokter.chat.index', compact('conversations'));
    }

    public function show(User $pasien)
    {
        $userId = Auth::id();
        
        $messages = Message::where(function($query) use ($userId, $pasien) {
            $query->where(function($q) use ($userId, $pasien) {
                $q->where('sender_id', $userId)->where('receiver_id', $pasien->id);
            })->orWhere(function($q) use ($userId, $pasien) {
                $q->where('sender_id', $pasien->id)->where('receiver_id', $userId);
            });
        })
        ->orderBy('created_at')
        ->get();

        Message::where('receiver_id', $userId)
            ->where('sender_id', $pasien->id)
            ->update(['is_read' => true]);

        return view('dokter.chat.show', compact('pasien', 'messages'));
    }

    public function store(Request $request, User $pasien)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $pasien->id,
            'message' => $request->message,
        ]);

        return redirect()->route('dokter.chat.show', $pasien->id);
    }
}
