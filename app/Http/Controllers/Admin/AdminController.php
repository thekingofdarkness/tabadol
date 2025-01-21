<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleVersion;
use App\Models\Bid;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogDivision;
use App\Models\ChatRoom;
use App\Models\Framework;
use App\Models\Offer;
use App\Models\User;
use App\Models\WebsiteSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OfferApproved;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Artisan;

use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
public function index()
{
    $offersCount = Offer::count();
    $usersCount = User::count();
    $bidsCount = Bid::count();
    $articlesCount = Article::count();
    $articlesEdits = ArticleVersion::count();
    $tSecondaryOffersCount = Offer::where('current_cadre', 't_secondary')->count();
    $tMiddleOffersCount = Offer::where('current_cadre', 't_middle')->count();
    $tPrimaryOffersCount = Offer::where('current_cadre', 't_primary')->count();

    // Count occurrences of required and current fields
    $requiredCommuneCounts = DB::table('offers')
        ->select('required_commune', DB::raw('count(*) as count'))
        ->groupBy('required_commune')
        ->get();

    $requiredDirCounts = DB::table('offers')
        ->select('required_dir', DB::raw('count(*) as count'))
        ->groupBy('required_dir')
        ->get();

    $requiredArefCounts = DB::table('offers')
        ->select('required_aref', DB::raw('count(*) as count'))
        ->groupBy('required_aref')
        ->get();

    $currentCommuneCounts = DB::table('offers')
        ->select('current_commune', DB::raw('count(*) as count'))
        ->groupBy('current_commune')
        ->get();

    $currentDirCounts = DB::table('offers')
        ->select('current_dir', DB::raw('count(*) as count'))
        ->groupBy('current_dir')
        ->get();

    $currentArefCounts = DB::table('offers')
        ->select('current_aref', DB::raw('count(*) as count'))
        ->groupBy('current_aref')
        ->get();

    return view('admin.index', compact(
        'offersCount', 'usersCount', 'bidsCount', 'tSecondaryOffersCount',
        'tPrimaryOffersCount', 'tMiddleOffersCount', 'articlesCount', 
        'articlesEdits', 'requiredCommuneCounts', 'requiredDirCounts', 
        'requiredArefCounts', 'currentCommuneCounts', 'currentDirCounts', 
        'currentArefCounts'
    ));
}


    //handles the user page in admin dash
    public function users()
    {

        // Get all users
        $users = User::orderBy('created_at', 'desc')->get();

        // Return the view with the data
        return view('admin.users', compact('users'));
    }

    //handles the offers page in admin dash
    public function offers()
    {
        $offers = Offer::orderBy('created_at', 'desc')->get();
        return view('admin.offers', compact('offers'));
    }
    //handles the approval of offers in admin dash
    public function offersApprove($id)
    {
        $offer = Offer::find($id);
        if ($offer) {
            $offer->status = 'approved';
            $offer->save();

            // Send a notification to the user
            $user = User::where('id', $offer->uid)->first();
            if ($user) {
                Notification::send($user, new OfferApproved($offer));
            }

            return redirect()->route('admin.offers.index')->with('success', 'Offer approved successfully!');
        }

        return redirect()->route('admin.offers.index')->with('error', 'Offer not found.');
    }

    //handles the bids and chatrooms related to it
    public function chatRooms()
    {
        $chatRooms = ChatRoom::with('messages.sender')
            ->get()
            ->sortByDesc(function ($chatRoom) {
                return $chatRoom->latest_activity;
            });
        return view('admin.chatRooms', compact('chatRooms'));
    }
    //show chatroom summary messages etc and also the sent of whatsapp ,notifications
    public function showChatRoom($id)
    {
        $chatRoom = ChatRoom::with('messages.sender')->findOrFail($id);
        function formatPhoneNumber($phone)
        {
            if (substr($phone, 0, 2) === '06') {
                // Format numbers starting with '06'
                return '+212' . substr($phone, 1);
            } elseif (substr($phone, 0, 4) !== '+212') {
                // Add country code to numbers that don't start with '+212'
                return '+212' . $phone;
            } else {
                // Keep the number as is if it already starts with '+212'
                return $phone;
            }
        }
        $chatRoom->receiverPhone = formatPhoneNumber($chatRoom->bid->receiver->phone);
        $chatRoom->bidderPhone = formatPhoneNumber($chatRoom->bid->bidder->phone);

        return view('admin.showChatRoom', compact('chatRoom'));
    }
    //manage frameworks like ex:اطار استاذ التعليم الابتدائي
    public function frameWorksManage()
    {
        //fetching existing frameworks 
        $frameworks = Framework::all();
        return view('admin.frameworks', compact('frameworks'));
    }
    //create new framework
    public function frameWroksCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codename' => 'required|string|unique:frameworks,codename',
            'arabic_name' => 'required|string'
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.frameworks.index')->withErrors($validator)->withInput();
        }
        $framework = new Framework();
        $framework->codename = $request->codename;
        $framework->arabic_name = $request->arabic_name;
        $framework->save();
        return redirect()->route('admin.frameworks.index')->with('success', 'Created successfully');
    }
    //update the framework
    public function frameWroksUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:frameworks,id',
            'codename' => 'required|string|unique:frameworks,codename,' . $request->id,
            'arabic_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        $framework = Framework::find($request->id);
        if ($framework) {
            $framework->codename = $request->codename;
            $framework->arabic_name = $request->arabic_name;
            $framework->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Framework updated successfully'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Framework not found'
        ], 404);
    }

    //shows index of the website settings 
    public function websiteManage()
    {
        $websiteSettings = WebsiteSetting::orderBy('created_at', 'desc')->get();
        return view('admin.website_settings', compact('websiteSettings'));
    }
    //handles the logic of creating new website setting
    public function wSettingsCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'position' => 'required|string|unique:website_settings,position',
            'arabic_content' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.wsettings.index')->withErrors($validator)->withInput();
        }
        $wSetting = new WebsiteSetting();
        $wSetting->position = $request->position;
        $wSetting->arabic_content = $request->arabic_content;
        $wSetting->save();
        return redirect()->route('admin.wsettings.index')->with('success', 'created successfully');
    }
    //handles the logic of updating a webste setting
    public function wSettingsUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'position' => 'required|string',
            'arabic_content' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 200); // 422 Unprocessable Entity
        }

        $wSetting = WebsiteSetting::find($request->id);
        if ($wSetting) {
            $wSetting->position = $request->position;
            $wSetting->arabic_content = $request->arabic_content;
            $wSetting->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Website Setting updated successfully'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'WebsiteSetting not found'
        ], 404);
    }
    //handles the logic of deleting a website settings
    public function wSettingsDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:website_settings,id'
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.wsettings.index')->withErrors($validator);
        }
        $wSetting = WebsiteSetting::findOrFail($request->id);
        $wSetting->delete();
        return redirect()->route('admin.wsettings.index')->with('success_update', 'operation succeed, what else do you need !');
    }

    //blog logic
    public function blogIndex()
    {
        $blogs = Blog::all();
        return view('admin.blog', compact('blogs'));
    }
    public function blogStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:blogs,title',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $blog = new Blog();
        $blog->title = $request->input('title');
        $blog->description = $request->input('description');
        $blog->save();
        return redirect()->back()->with('success', 'Blog created successfully');
    }
    public function blogUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $blog = Blog::findOrFail($id);
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->save();

        return response()->json(['updatedBlog' => $blog]);
    }
    public function blogDelete(Request $request)
    {
        $blog = Blog::findOrFail($request->input('id'));
        $blog->delete();
        return redirect()->back();
    }
    public function divisionDelete(Request $request)
    {
        $blog = BlogDivision::findOrFail($request->input('id'));
        $blog->delete();
        return redirect()->back();
    }
    public function blogDivision()
    {
        $blogs = Blog::all();
        $divisions = BlogDivision::all();
        return view('admin.divisions', compact('blogs', 'divisions'));
    }
    public function blogDivisionStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:blogs,title',
            'blog_id' => 'required|exists:blogs,id',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $division = new BlogDivision();
        $division->title = $request->input('title');
        $division->description = $request->input('description');
        $division->blog_id = $request->input('blog_id');
        $division->save();
        return redirect()->back()->with('success', 'Blog created successfully');
    }
    public function divisionUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'blog_id' => 'required|integer|exists:blogs,id'
        ]);

        $division = BlogDivision::findOrFail($id);
        $division->title = $request->title;
        $division->description = $request->description;
        $division->blog_id = $request->blog_id;
        $division->save();
        return response()->json(['updatedBlog' => $division]);
    }
    public function blogCategories()
    {
        $blogs = Blog::all();
        $divisions = BlogDivision::all();
        $categories = BlogCategory::all();
        return view('admin.categories', compact('blogs', 'divisions', 'categories'));
    }
    public function blogCategoryStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:blogs,title',
            'division_id' => 'required|exists:blog_divisions,id',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $category = new BlogCategory();
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        $category->division_id = $request->input('division_id');
        $category->save();
        return redirect()->back()->with('success', 'Blog created successfully');
    }
    public function categoryUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'division_id' => 'required|integer|exists:blog_divisions,id'
        ]);

        $category = BlogCategory::findOrFail($id);
        $category->title = $request->title;
        $category->description = $request->description;
        $category->division_id = $request->division_id;
        $category->save();

        return response()->json(['updatedBlog' => $category]);
    }
    public function categoryDelete(Request $request)
    {
        $cat = BlogCategory::findOrFail($request->input('id'));
        $cat->delete();
        return redirect()->back();
    }

    // Reviewing articles
    public function articlesReview()
    {
        $articles = ArticleVersion::orderBy('created_at', 'desc')->get();
        return view('admin.articles_review', compact('articles'));
    }

    // Approving articles
    public function articlesApprove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:article_versions,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $article = ArticleVersion::findOrFail($request->id);
        $article->is_approved = 1;
        $article->save();

        return response()->json(['message' => 'Article approved successfully']);
    }

    // Disapproving articles
    public function articlesDisapprove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:article_versions,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $article = ArticleVersion::findOrFail($request->id);
        $article->is_approved = 0;
        $article->save();

        return response()->json(['message' => 'Article disapproved successfully']);
    }

    // Deleting articles
    public function articlesDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:article_versions,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $article = ArticleVersion::findOrFail($request->id);
        $article->delete();

        return response()->json(['message' => 'Article deleted successfully']);
    }
    public function articlesOriginalDelete(Request $request)
    {
        $article = Article::findOrFail($request->id);
        $article->delete();
        return redirect()->back();
    }
    
    public function generateSitemap()
    {
        Artisan::call('sitemap:generate');

        return "generated successfully";
    }
    
public function runMatchingLogic()
{
    // Fetch all users from the database with their offers
    $users = User::with('offers')->get(); // Eager load offers to avoid N+1 query problem
    $newMatchesCount = 0;

    foreach ($users as $user) {
        // Retrieve the IDs of the user's own offers
        $userOfferIds = $user->offers->pluck('id')->toArray(); // Get the IDs of the user's own offers

        echo "Processing user ID: {$user->id} <br/>";
        echo "User's offers IDs: " . implode(', ', $userOfferIds) . "<br/>";

        // Find matching users
        $matchingUsers = User::whereHas('offers', function($query) use ($user, $userOfferIds) {
            $query->where(function($subQuery) use ($user) {
                $subQuery->where('current_cadre', $user->current_cadre)
                         ->where('required_commune', $user->current_commune)
                         ->where('required_institution', $user->current_institution);
            })->orWhere(function($subQuery) use ($user) {
                $subQuery->where('current_commune', $user->required_commune)
                         ->where('current_institution', $user->required_institution)
                         ->where('required_commune', $user->current_commune)
                         ->where('required_institution', $user->current_institution);
            });
        })->get();

        // Debug: Display matching users
        echo "Matching users found: " . $matchingUsers->count() . "<br/>";
        foreach ($matchingUsers as $matchingUser) {
            echo "Matching user ID: {$matchingUser->id} <br/>";
        }

        // Process matching users
        foreach ($matchingUsers as $matchingUser) {
            // Exclude the current user's own offers
            $offers = $matchingUser->offers->filter(function($offer) use ($userOfferIds) {
                return !in_array($offer->id, $userOfferIds);
            });

            // Debug: Display offers
            echo "Offers found for matching user ID: {$matchingUser->id} <br/>";
            foreach ($offers as $offer) {
                echo "Offer ID: {$offer->id} <br/>";
            }

            foreach ($offers as $offer) {
                // Send notification to the user
                // $user->notify(new MatchingOfferNotification($offer));

                // Record that the user has been notified about this offer
                DB::table('user_offer_notifications')->insert([
                    'user_id' => $user->id,
                    'offer_id' => $offer->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $newMatchesCount++;
            }
        }

        if ($newMatchesCount === 0) {
            echo "No matching offers for user ID: {$user->id} <br/>";
        }
    }

    // Return a message indicating the result
    return "$newMatchesCount new match(es) found and notifications sent.";
}

}
