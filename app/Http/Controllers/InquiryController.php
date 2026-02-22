<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:general,investor,event,property',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'ready_to_buy' => ['nullable', 'string', 'max:100'],
            'investment_type' => ['nullable', 'string', 'max:100'],
            'is_cash_buyer' => ['nullable', 'string', 'max:10'],
            'budget' => ['nullable', 'string', 'max:255'],
            'experience_level' => ['nullable', 'string', 'max:100'],
            'comments' => 'nullable|string',
            'source_page' => 'nullable|string',
            'property_id' => 'nullable|exists:available_properties,id',
            'owner_id' => 'nullable|exists:users,id',
        ]);

        // Create inquiry
        $inquiry = Inquiry::create($validated);

        // Send email based on type
        $this->sendInquiryEmail($inquiry);

        return back()->with('success', 'Thank you for your inquiry! We will get back to you soon.');
    }

    private function sendInquiryEmail($inquiry)
    {
        $emailData = [
            'name' => $inquiry->name,
            'email' => $inquiry->email,
            'phone' => $inquiry->phone,
            'ready_to_buy' => $inquiry->ready_to_buy,
            'investment_type' => $inquiry->investment_type,
            'is_cash_buyer' => $inquiry->is_cash_buyer,
            'budget' => $inquiry->budget,
            'experience_level' => $inquiry->experience_level,
            'comments' => $inquiry->comments,
            'source_page' => $inquiry->source_page,
            'type' => $inquiry->type,
        ];

        // All inquiries should go to the main admin email
        $recipient = 'webleads@propertysourcinggroup.co.uk';

        try {
            Mail::send('emails.inquiry', $emailData, function ($message) use ($recipient, $inquiry) {
                $message->to($recipient)
                    ->from('inquiries@propertysourcinggroup.co.uk', 'Property Sourcing Group')
                    ->subject('New ' . ucfirst($inquiry->type) . ' Inquiry from ' . $inquiry->name);
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send inquiry email: ' . $e->getMessage());
        }
    }

    // Admin methods
    public function index(Request $request)
    {
        $query = Inquiry::query();

        // If user is agent, they can only see their own property inquiries
        if (auth()->user()->role === 'agent') {
            $query->where('owner_id', auth()->id())
                ->where('type', 'property');
        }

        // Stats calculation based on base query
        $totalCount = (clone $query)->count();
        $unreadCount = (clone $query)->unread()->count();
        $investorCount = (clone $query)->where('type', 'investor')->count();
        $eventCount = (clone $query)->where('type', 'event')->count();

        // Filter by type if provided (for view filtering)
        if ($request->has('type') && in_array($request->type, ['general', 'investor', 'event', 'property'])) {
            $query->where('type', $request->type);
        }

        $inquiries = $query->latest()->get(); // Use get() for DataTables compatibility

        return view('admin.inquiries.index', compact(
            'inquiries',
            'totalCount',
            'unreadCount',
            'investorCount',
            'eventCount'
        ));
    }

    public function show($id)
    {
        $inquiry = Inquiry::findOrFail($id);

        // Security check for agents
        if (auth()->user()->role === 'agent' && $inquiry->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this inquiry.');
        }

        // Mark as read
        if (!$inquiry->is_read) {
            $inquiry->update(['is_read' => true]);
        }

        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function destroy($id)
    {
        $inquiry = Inquiry::findOrFail($id);

        // Security check for agents
        if (auth()->user()->role === 'agent' && $inquiry->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $inquiry->delete();

        return back()->with('success', 'Inquiry deleted successfully.');
    }

    public function markAsRead($id)
    {
        $inquiry = Inquiry::findOrFail($id);

        // Security check for agents
        if (auth()->user()->role === 'agent' && $inquiry->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $inquiry->update(['is_read' => true]);

        return back()->with('success', 'Inquiry marked as read.');
    }

    public function markAsUnread($id)
    {
        $inquiry = Inquiry::findOrFail($id);

        // Security check for agents
        if (auth()->user()->role === 'agent' && $inquiry->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $inquiry->update(['is_read' => false]);

        return back()->with('success', 'Inquiry marked as unread.');
    }
}
