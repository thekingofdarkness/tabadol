<?php

namespace App\Http\Controllers\Swapping;

use App\Http\Controllers\Controller;
use App\Helpers\TranslationHelper;
use App\Models\Bid;
use App\Models\Offer;
use App\Models\ChatRoom;
use App\Notifications\BidPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\BidAccepted;


class BidController extends Controller
{
    public function show(Offer $offer)
    {
        $hasBid = Bid::where('offer_id', $offer->id)
            ->where('bidder_id', Auth::id())
            ->exists();

        $bid = null; // Initialize $bid as null

        if ($hasBid) {
            $bid = Bid::where('offer_id', $offer->id)
                ->where('bidder_id', Auth::id())
                ->with('chatroom')
                ->first(); // Use first() to get the actual Bid instance

            // Translate the current cadre of the offer
            $offer->current_cadre = TranslationHelper::translate($offer->current_cadre);

            // Translate the status of the bid
            $bid->status_ar = TranslationHelper::translate($bid->status);
        }

        return view('bids.create', compact('offer', 'hasBid', 'bid'));
    }


    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'offer_id' => 'required|integer|exists:offers,id',
            'note' => 'required|string|min:10'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Retrieve the offer data
        $offer = Offer::findOrFail($request->offer_id);

        // Check for duplicate bid
        $existingBid = Bid::where('offer_id', $request->offer_id)
            ->where('bidder_id', Auth::id())
            ->where('note', $request->note)
            ->exists();

        if ($existingBid) {
            // Redirect back with an error message
            return redirect()->back()->with('error', 'وضعت عرضا سابقا بنفس الرسالة');
        }

        // Create a new bid instance
        $bid = new Bid();
        $bid->note = $request->note;
        $bid->offer_id = $request->offer_id;
        $bid->bidder_id = Auth::id();
        $bid->receiver_id = $offer->uid;
        $bid->save();

        // Create a chat room for the bid
        $chatRoom = ChatRoom::create(['bid_id' => $bid->id]);
        $offer->user->notify(new BidPlaced($bid));
        // Redirect back with a success message
        return redirect()->back()->with('success', 'تم إرسال العرض بنجاح');
    }

    public function list($offerId)
    {
        $bids = Bid::where('receiver_id', Auth::id())->where('offer_id', $offerId)->with('bidder', 'offer', 'chatRoom')->orderBy('created_at', 'desc')->get();
        $bids->transform(function ($bids) {
            $bids->status_ar = TranslationHelper::translate($bids->status);
            return $bids;
        });
        return view('bids.list', compact('bids'));
    }

    public function mylist()
    {
        $bids = Bid::where('bidder_id', Auth::id())->with('bidder', 'offer', 'chatRoom')->get();
        $bids->transform(function ($bids) {
            $bids->status_ar = TranslationHelper::translate($bids->status);
            return $bids;
        });
        return view('bids.mybids', compact('bids'));
    }

    public function acceptBid($bidId)
    {
        $bid = Bid::findOrFail($bidId);

        // Ensure only the receiver can accept the bid
        if ($bid->receiver_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Update bid status
        $bid->status = 'accepted';
        $bid->save();

        // Create a chat room for this bid if it doesn't exist
        if (!$bid->chatRoom) {
            $chatRoom = ChatRoom::create(['bid_id' => $bid->id]);
        } else {
            $chatRoom = $bid->chatRoom;
        }

        // Notify the bidder
        $bid->bidder->notify(new BidAccepted($bid));

        return redirect()->route('chat.index', ['chatRoomId' => $chatRoom->id]);
    }
    public function unreadMessagesCount($id)
    {
        $chatRoom = ChatRoom::findOrFail($id);
        $unreadMessagesCount = $chatRoom->unreadMessagesCount();
        return $unreadMessagesCount;
    }
}
