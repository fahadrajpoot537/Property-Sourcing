<?php

namespace App\Http\Controllers;

use App\Models\PropertyMessage;
use App\Models\AvailableProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PropertyMessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:available_properties,id',
            'message' => 'required|string|max:1000',
        ]);

        $property = AvailableProperty::findOrFail($request->property_id);
        $receiverId = 1; // Always send to admin

        if (Auth::id() == $receiverId) {
            return back()->with('error', 'Admin cannot send messages to themselves.');
        }

        $message = PropertyMessage::create([
            'available_property_id' => $property->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Notify admin via email
        $this->sendMessageNotification($message, $property);

        return back()->with('success', 'Message sent successfully!');
    }

    private function sendMessageNotification($propertyMessage, $property)
    {
        $adminEmail = 'webleads@propertysourcinggroup.co.uk';
        $user = Auth::user();

        $data = [
            'user_name' => $user->name,
            'user_email' => $user->email,
            'property_title' => $property->headline,
            'property_location' => $property->location,
            'message_text' => $propertyMessage->message,
            'message_url' => route('admin.messages.index'),
        ];

        try {
            Mail::send('emails.property_message', $data, function ($message) use ($adminEmail, $property, $user) {
                $message->to($adminEmail)
                    ->subject('New Property Message: ' . $property->headline . ' from ' . $user->name);
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send message notification email: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of the resource for the logged-in user.
     */
    public function index()
    {
        $messages = PropertyMessage::with(['sender', 'property'])
            ->where('receiver_id', Auth::id())
            ->orWhere('sender_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.messages.index', compact('messages'));
    }
}
