<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required_if:uid,null|string|max:255',
            'content' => 'required|string',
            'captcha' => 'required|captcha'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->article_id = $request->article_id;

        if (Auth::check()) {
            $comment->uid = Auth::id();
            $comment->name = Auth::user()->name;
        } else {
            $comment->name = $request->name;
        }
        $comment->save();

        return redirect()->back()->with('message', 'تم نشر تعليقك بنجاح!');
    }
    public function delete($id)
    {
        $comment = Comment::find($id);
        if ($comment->uid === Auth::user()->id || $Auth::user()->is_admin) {
            if ($comment) {
                $comment->delete();
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }
}
