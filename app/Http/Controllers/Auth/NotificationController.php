<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function unreadCount()
    {
        $unreadCount = Auth::user()->unreadNotifications->count();

        return response()->json(['unread_count' => $unreadCount]);
    }

    public function getNotifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->get();

        $html = '';

        if ($notifications->isEmpty()) {
            $html .= '<a class="dropdown-item" href="#"> No new notifications </a>';
        } else {
            foreach ($notifications as $notification) {
                $html .= $this->generateNotificationHtml($notification);
            }

            if ($user->unreadNotifications->count() > 0) {
                $html .= '<div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="' . route('notifications.markAsRead') . '"> Mark all as read </a>';
            }
        }

        return response()->json(['html' => $html]);
    }

    private function generateNotificationHtml($notification)
    {
        $html = '';
        if ($notification->type === 'App\Notifications\BidPlaced') {
            $html .= '<a class="dropdown-item" href="' . route('recieved.bids', $notification->data['offer_id']) . '">
                        تم وضع عرض على طلبك : ' . (!empty($notification->data['offer_title']) ? $notification->data['offer_title'] : '') . '
                        <br>
                        <small>' . $notification->created_at->diffForHumans() . '</small>
                      </a>';
        } elseif ($notification->type === 'App\Notifications\OfferAccepted') {
            $html .= '<a class="dropdown-item" href="#">
                        تم قبول طلبكم رقم : ' . $notification->data['offer_id'] . '.
                        <br>
                        <small>' . $notification->created_at->diffForHumans() . '</small>
                      </a>';
        } elseif ($notification->type === 'App\Notifications\AdminNotification') {
            $html .= '<a class="dropdown-item" href="' . $notification->data['url'] . '">
                        Admin: ' . $notification->data['message'] . '
                        <br>
                        <small>' . $notification->created_at->diffForHumans() . '</small>
                      </a>';
        } elseif ($notification->type === 'App\Notifications\BidAccepted') {
            $html .= '<a class="dropdown-item" href="' . route('chat.index', ['chatRoomId' => $notification->data['chat_room_id']]) . '">
                         ' . $notification->data['message'] . '
                        <br>
                        <small>' . $notification->created_at->diffForHumans() . '</small>
                      </a>';
        } elseif ($notification->type === 'App\Notifications\OfferApproved') {
            $html .= '<a class="dropdown-item" href="' . route('offers.show', ['offer' => $notification->data['offer_id']]) . '">
                         ' . $notification->data['message'] . '' . $notification->data['offer_id'] . ' 
                        <br>
                        <small>' . $notification->created_at->diffForHumans() . '</small>
                      </a>';
        }

        return $html;
    }

    public function markAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }
}
