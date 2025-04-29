<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        // 投稿を新しい順で取得！
        $posts = \App\Models\Post::latest()->get();
        return view('posts.index', compact('posts'));
    }
    
    // 投稿作成画面を表示する
    public function create()
    {
        return view('posts.create');
    }

    // 投稿を保存する
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'url' => 'nullable|url|max:255',
        ]);

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
        ]);

        return redirect('/')->with('success', '投稿が作成されました！');
    }
}
