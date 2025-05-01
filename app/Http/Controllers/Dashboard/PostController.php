<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    /* 一覧 */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('dashboard.posts.index', compact('posts'));
    }

    /* 公開側一覧 */
    public function publicIndex()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    /* 作成画面 */
    public function create()
    {
        return view('dashboard.posts.create');
    }

    /* 新規投稿 */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'required',
            'url'         => 'nullable|url|max:255',
            'files.*'     => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:51200',
        ]);

        $post = Post::create($request->only('title', 'description', 'url'));

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                try {
                    /* ---------- 修正済み ---------- */
                    $path = $file->storePublicly('posts', 's3', 'public');

                    $fileType = str_starts_with($file->getMimeType(), 'image') ? 'image' : 'video';

                    $post->files()->create([
                        'file_path' => $path,
                        'file_type' => $fileType,
                    ]);
                } catch (\Exception $e) {
                    Log::error('ファイルアップロード失敗: '.$e->getMessage());
                }
            }
        }

        return redirect()->route('posts.index')->with('success', '投稿しました！');
    }

    /* 編集画面 */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('dashboard.posts.edit', compact('post'));
    }

    /* 更新 */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'required',
            'url'         => 'nullable|url|max:255',
            'files.*'     => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->only('title', 'description', 'url'));

        /* 既存ファイルを削除して再登録する方針 */
        if ($request->hasFile('files')) {
            foreach ($post->files as $f) {
                Storage::disk('s3')->delete($f->file_path);
                $f->delete();
            }

            foreach ($request->file('files') as $file) {
                try {
                    /* ---------- 修正済み ---------- */
                    $path = $file->storePublicly('posts', 's3', 'public');

                    $fileType = str_starts_with($file->getMimeType(), 'image') ? 'image' : 'video';

                    $post->files()->create([
                        'file_path' => $path,
                        'file_type' => $fileType,
                    ]);
                } catch (\Exception $e) {
                    Log::error('ファイルアップロード失敗: '.$e->getMessage());
                }
            }
        }

        return redirect()->route('posts.index')->with('success', '投稿を更新しました！');
    }

    /* 削除 */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        foreach ($post->files as $file) {
            Storage::disk('s3')->delete($file->file_path);
            $file->delete();
        }

        $post->delete();
        return redirect()->route('posts.index')->with('success', '投稿と関連ファイルを削除しました！');
    }
}
