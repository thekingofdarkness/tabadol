<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    public function bids()
    {
        return $this->hasMany(Bid::class, 'bidder_id');
    }

    public function receivedBids()
    {
        return $this->hasMany(Bid::class, 'receiver_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'uid');
    }
    public function articles()
    {
        return $this->hasMany(Article::class, 'uid');
    }
    public function article_versions()
    {
        return $this->hasMany('article_versions', 'uid');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'uid');
    }
}
