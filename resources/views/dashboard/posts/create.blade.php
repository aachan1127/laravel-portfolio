<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新しい投稿を作成</title>

    {{-- 既存 UI と同じスタイル --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- 投稿画面だけの軽いカスタム --}}
    <style>
        /* フォーム全体をカード風に */
        .post-form {
            max-width: 720px;
            margin: 32px auto;
            padding: 32px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,.06);
        }
        .post-form h1   { margin-top: 0; }
        .post-form label{ font-weight: 600; display:block; margin-bottom:4px; }
        .post-form input[type="text"],
        .post-form textarea,
        .post-form input[type="url"]{
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccd5df;
            border-radius: 6px;
            font-size: 1rem;
            line-height: 1.5;
        }
        /* 説明欄を大きく (8 行) */
        .post-form textarea{
            min-height: 8rem;    /* = 8 行程度 */
            resize: vertical;
        }
        .post-form .field { margin-bottom: 20px; }
        .post-form .note  { font-size: .85rem; color:#777; }
        .post-form .btn   {
            display:inline-block; padding:10px 24px; font-weight:600;
            background:#3b82f6; color:#fff; border:none; border-radius:6px;
            cursor:pointer; transition:background .15s;
        }
        .post-form .btn:hover { background:#2563eb; }
    </style>
</head>
<body>

    <a href="{{ route('posts.index') }}" style="margin-left:16px;">← 一覧に戻る</a>

    <form class="post-form" method="POST" action="{{ route('posts.store') }}"
          enctype="multipart/form-data">
        @csrf
        <h1>新しい投稿</h1>

        {{-- タイトル --}}
        <div class="field">
            <label for="title">タイトル</label>
            <input type="text" id="title" name="title"
                   value="{{ old('title') }}" required>
        </div>

        {{-- 説明 ――― textarea を大きく --}}
        <div class="field">
            <label for="description">説明</label>
            <textarea id="description" name="description" required>{{ old('description') }}</textarea>
        </div>

        {{-- 外部 URL --}}
        <div class="field">
            <label for="url">外部リンク（任意）</label>
            <input type="url" id="url" name="url" value="{{ old('url') }}"
                   placeholder="https://example.com">
        </div>

        {{-- ファイル --}}
        <div class="field">
            <label for="files">画像／動画(複数可)</label>
            <input type="file" id="files" name="files[]" multiple>
            <p class="note">対応: jpg / png / gif / mp4 / mov / avi &nbsp; 最大 50 MB × N</p>
        </div>

        <button type="submit" class="btn">投稿する</button>
    </form>

</body>
</html>
