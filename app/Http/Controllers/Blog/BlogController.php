<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleVersion;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BlogController extends Controller
{
public function index(Request $request)
{
    $query = Article::query();

    if ($request->filled('division')) {
        $query->whereHas('category.division', function ($q) use ($request) {
            $q->where('id', $request->division);
        });
    }

    if ($request->filled('category')) {
        $query->whereHas('category', function ($q) use ($request) {
            $q->where('id', $request->category);
        });
    }

    // Corrected orderBy chaining directly on the $query object
    $articles = $query->orderBy('updated_at', 'desc')
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

    $divisions = BlogDivision::all();
    $categories = BlogCategory::all();

    return view('blog.index', compact('articles', 'divisions', 'categories'));
}




    public function create()
    {
        $divisions = BlogDivision::all();
        return view('blog.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'title' => 'required|string|max:255|unique:articles,title',
                'content' => 'required|string',
                'category_id' => 'required|integer|exists:blog_categories,id',
                'thumbnail' => 'required|image|max:2048' // Validate thumbnail as an image with max size of 2MB
            ], [], ['category_id' => 'الاقسام/التصنيف', 'title' => 'العنوان', 'content' => 'المحتوى']);

            // Handle the thumbnail file upload
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailPath = $thumbnail->store('thumbnails', 'public');
            }

            // Generate a slug from the title
            $slug = \Str::slug($request->input('title'));

            // Save the content to the database
            $article = new Article();
            $article->title = $validatedData['title'];
            $article->slug = $slug;
            $article->content = $validatedData['content'];
            $article->thumbnail = $thumbnailPath;
            $article->uid = Auth::id();
            $article->category_id = $validatedData['category_id'];
            $article->save();

            // Return a JSON response with the URL of the new article
            return response()->json([
                'articleUrl' => route('blog.article.show', ['slug' => $slug])
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors as JSON
            return response()->json([
                'errors' => $e->errors()
            ], 422); // 422 Unprocessable Entity status code
        }
    }


    public function update(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|unique:article_versions,content',
            'article_id' => 'required|integer|exists:articles,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Save the content to the database
        $article = new ArticleVersion();
        $article->content = $request->input('content');
        $article->uid = Auth::id();
        $article->article_id = $request->input('article_id');
        $article->save();

        return response()->json(['Message' => 'تم حفظ اقتراح التعديل الخاص بكم']);
    }

    public function show($slug, $date = null, $original = null)
    {
        // Fetch the article or fail
        $oarticle = Article::where('slug', $slug)->firstOrFail();

        // Fetch the newest approved version of the article, if any
        $approvedVersion = ArticleVersion::where('article_id', $oarticle->id)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->first();

        // Determine which article version to use
        $article = ($original || !$approvedVersion) ? $oarticle : $approvedVersion;

        // Fetch the current user's latest article version
        $article_version = ArticleVersion::where('uid', Auth::id())
            ->where('article_id', $oarticle->id)
            ->latest()
            ->first();

        // Fetch all versions of the article ordered from newest to oldest
        $versions = ArticleVersion::where('article_id', $oarticle->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Default to null
        $pendingArticleContent = null;

        // Check if a date is provided
        if ($date) {
            // Convert date string to a Carbon instance for accurate comparison
            $date = Carbon::parse($date);

            // Fetch the article version with the exact timestamp
            $pendingArticleContent = ArticleVersion::where('article_id', $oarticle->id)
                ->whereDate('created_at', $date->toDateString()) // Check if the date matches
                ->whereTime('created_at', $date->toTimeString()) // Check if the time matches
                ->first();
        }

        // Return the view with data
        return view('blog.show_article', compact('article', 'article_version', 'versions', 'pendingArticleContent', 'original', 'oarticle'));
    }

    public function getCategories($divisionId)
    {
        $categories = BlogCategory::where('division_id', $divisionId)->get(['id', 'title']);
        return response()->json(['categories' => $categories]);
    }
}
