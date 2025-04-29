<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // 投稿を新しい順で全部取得
        $posts = Post::latest()->get();

        // 管理者用のビューに渡す
        return view('dashboard.posts.index', compact('posts'));
    }

    public function edit($id)
    {
        $post = \App\Models\Post::findOrFail($id);
        // $post = Post::findOrFail($id);

        return view('dashboard.posts.edit', compact('post'));
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'url' => 'nullable|url|max:255',
        ]);

        $post = \App\Models\Post::findOrFail($id);
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
        ]);

        return redirect()->route('posts.index')->with('success', '投稿を更新しました！');
    }

    // 削除処理
    public function destroy($id)
    {
        $post = \App\Models\Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', '投稿を削除しました！');
    }

    // 新しい投稿
    public function create()
    {
        return view('dashboard.posts.create');
    }
}
