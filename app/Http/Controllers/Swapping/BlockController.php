<?php

namespace App\Http\Controllers\Swapping;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockController extends Controller
{
    public function block($userId)
    {
        Block::create([
            'blocker_id' => Auth::id(),
            'blocked_id' => $userId
        ]);

        return redirect()->back()->with('success', 'User blocked successfully.');
    }

    public function unblock($userId)
    {
        Block::where('blocker_id', Auth::id())->where('blocked_id', $userId)->delete();

        return redirect()->back()->with('success', 'User unblocked successfully.');
    }
}
