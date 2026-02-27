<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Message;
use App\Models\Booking;
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

        $doctors = User::whereHas('roles', function($query) {
            $query->where('name', 'dokter');
        })
        ->where('is_active', true)
        ->with('doctorProfile')
        ->get();

        return view('pasien.chat.index', compact('conversations', 'doctors'));
    }

    public function show(User $dokter)
    {
        $userId = Auth::id();
        
        $messages = Message::where(function($query) use ($userId, $dokter) {
            $query->where(function($q) use ($userId, $dokter) {
                $q->where('sender_id', $userId)->where('receiver_id', $dokter->id);
            })->orWhere(function($q) use ($userId, $dokter) {
                $q->where('sender_id', $dokter->id)->where('receiver_id', $userId);
            });
        })
        ->orderBy('created_at')
        ->get();

        Message::where('receiver_id', $userId)
            ->where('sender_id', $dokter->id)
            ->update(['is_read' => true]);

        return view('pasien.chat.show', compact('dokter', 'messages'));
    }

    public function store(Request $request, User $dokter)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $dokter->id,
            'message' => $request->message,
        ]);

        return redirect()->route('pasien.chat.show', $dokter->id);
    }
}
