<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Helpers\TranslationHelper;
use App\Models\Article;
use App\Models\Framework;
use App\Models\Offer;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use HTMLPurifier;
use HTMLPurifier_Config;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Initialize the query based on whether the user is authenticated or not
        $query = Offer::query();
        /*
        if (Auth::check()) {
            $query->where('uid', '!=', Auth::id());
        }
    */
        $query->orderBy('created_at', 'desc');

        // Apply search filters if present
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('current_commune', 'like', '%' . $searchTerm . '%')
                    ->orWhere('speciality', 'like', '%' . $searchTerm . '%')
                    ->orWhere('current_dir', 'like', '%' . $searchTerm . '%')
                    ->orWhere('required_dir', 'like', '%' . $searchTerm . '%')
                    ->orWhere('required_commune', 'like', '%' . $searchTerm . '%')
                    ->orWhere('required_aref', 'like', '%' . $searchTerm . '%')
                    ->orWhere('current_aref', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply cadre filter if selected
        if ($request->filled('cadre')) {
            $query->where('current_cadre', $request->cadre);
        }

        // Paginate the results
        $offers = $query->paginate(10);

        // Transform the offers
        $offers->getCollection()->transform(function ($offer) {
            $offer->current_cadre = TranslationHelper::translate($offer->current_cadre);
            $offer->current_aref = TranslationHelper::translate($offer->current_aref);
            $offer->required_dir = TranslationHelper::translate($offer->required_dir);
            $offer->current_dir = TranslationHelper::translate($offer->current_dir);
            $offer->required_aref = TranslationHelper::translate($offer->required_aref);
            return $offer;
        });
        $frameworks = Framework::all();
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        // Retrieve the single record expected
        $general_index_under_hero_col = WebsiteSetting::where('position', 'general_index_under_hero')->first();

        // Check if the record exists
        if ($general_index_under_hero_col) {
            // Sanitize the content
            $general_index_under_hero = $purifier->purify($general_index_under_hero_col->arabic_content);
        } else {
            // Handle the case where no record is found
            $general_index_under_hero = '';
        }
        $articles = Article::orderBy('created_at', 'desc')->take(3)->get();
        return view('home', compact('offers', 'frameworks', 'general_index_under_hero', 'articles'));
    }
}
