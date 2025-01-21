<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function privacy()
    {
        return view('pages.privacy');
    }
    public function usageAgreement()
    {
        return view('pages.agreement');
    }
    public function aboutUs()
    {
        return view('pages.about');
    }
    function team()
    {
        return view('pages.team');
    }
    function contactUs()
    {
        return view('pages.contact');
    }
}
