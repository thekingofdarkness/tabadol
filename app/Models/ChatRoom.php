<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'bid_id',
        'status'
    ];

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function unreadMessagesCount()
    {
        return $this->messages()->whereNull('seen_at')->count();
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
