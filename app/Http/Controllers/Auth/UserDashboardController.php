<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use HTMLPurifier;
use HTMLPurifier_Config;

class UserDashboardController extends Controller
{
    public function index()
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        // Retrieve the single record expected
        $userDashboardIndexSetting = WebsiteSetting::where('position', 'user_dashboard_index_note')->first();

        // Check if the record exists
        if ($userDashboardIndexSetting) {
            // Sanitize the content
            $userDashboardIndexNote = $purifier->purify($userDashboardIndexSetting->arabic_content);
        } else {
            // Handle the case where no record is found
            $userDashboardIndexNote = '';
        }

        return view('dashboard.index', compact('userDashboardIndexNote'));
    }
}
