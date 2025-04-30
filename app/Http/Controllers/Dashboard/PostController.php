<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\PostFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


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

    // 投稿処理
    public function publicIndex()
    {
        $posts = \App\Models\Post::latest()->get();

        return view('posts.index', compact('posts'));
    }

    // store()メソッド
    // PostController.php  ─ store() 全面
    public function store(Request $request)
    {
        /* 1. バリデーション */
        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'required',          // ← description を必須に
            'url'         => 'nullable|url|max:255',
            'files.*'     => 'file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240',
        ]);

        /* 2. 本体を保存 */
        $post = Post::create($request->only('title', 'description', 'url'));

        /* 3. ファイルがあれば S3 へ */
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('posts', 's3');
                $type = str_starts_with($file->getMimeType(), 'image') ? 'image' : 'video';

                $post->files()->create([
                    'file_path' => $path,
                    'file_type' => $type,
                ]);
            }
        }

        return redirect()->route('posts.index')->with('success', '投稿しました！');
    }
}
