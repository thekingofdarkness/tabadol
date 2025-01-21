<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'current_cadre',
        'current_aref',
        'current_dir',
        'current_commune',
        'current_institution',
        'required_aref',
        'required_dir',
        'required_commune',
        'required_institution',
        'note',
        'status',
        'speciality'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'uid', 'id'); // Ensure 'uid' in offers references 'id' in users
    }
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}
