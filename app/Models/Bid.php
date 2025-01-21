<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;
    protected $fillable = ['note', 'status'];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function bidder()
    {
        return $this->belongsTo(User::class, 'bidder_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

    public function chatRoom()
    {
        return $this->hasOne(ChatRoom::class);
    }
}
