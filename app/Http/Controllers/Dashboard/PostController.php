<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\PostFile;
use Illuminate\Support\Facades\Storage;

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

    // 投稿処理
    public function publicIndex()
    {
        $posts = \App\Models\Post::latest()->get();

        return view('posts.index', compact('posts'));
    }

    // store() メソッド
    public function store(Request $request)
    {
        // 基本バリデーション
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required',
            'url' => 'nullable|url|max:255',
        ];

        // ファイルがあるときだけ追加
        if ($request->hasFile('files')) {
            $rules['files.*'] = 'file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240';
        }

        $request->validate($rules);


        // 投稿の保存
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
        ]);

        // 複数ファイルの保存
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('posts', 'public');

                $mime = $file->getMimeType();
                $fileType = str_starts_with($mime, 'image') ? 'image' : 'video';

                PostFile::create([
                    'post_id' => $post->id,
                    'file_path' => $path,
                    'file_type' => $fileType,
                ]);
            }
        }

        return redirect()->route('posts.index')->with('success', '投稿が作成されました！');
    }
}
