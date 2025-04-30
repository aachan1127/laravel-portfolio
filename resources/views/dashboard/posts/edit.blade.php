<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>投稿を編集</title>
</head>
<body>
    <h1>投稿を編集</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label>タイトル</label><br>
            <input type="text" name="title" value="{{ old('title', $post->title) }}">
        </div>

        <div>
            <label>説明</label><br>
            <textarea name="description">{{ old('description', $post->description) }}</textarea>
        </div>

        <div>
            <label>URL</label><br>
            <input type="url" name="url" value="{{ old('url', $post->url) }}">
        </div>

        {{-- 現在の画像/動画 --}}
        <div>
            <label>現在のメディア:</label><br>
            @foreach ($post->files as $file)
                @if ($file->file_type === 'image')
                    <img src="{{ Storage::disk('s3')->url($file->file_path) }}" alt="画像" width="150"><br>
                @elseif ($file->file_type === 'video')
                    <video width="300" controls>
                        <source src="{{ Storage::disk('s3')->url($file->file_path) }}">
                        お使いのブラウザは video タグに対応していません。
                    </video><br>
                @endif
            @endforeach
        </div>

        <div>
            <label>新しい画像・動画を選択（複数可）</label><br>
            <input type="file" name="files[]" multiple accept="image/*,video/*">
        </div>

        <button type="submit">更新する</button>
    </form>

    <p><a href="{{ route('posts.index') }}">← 投稿一覧に戻る</a></p>

    {{-- 拡張子のアラート --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.querySelector('input[type="file"]');

            if (fileInput) {
                fileInput.addEventListener('change', () => {
                    const validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi'];
                    for (const file of fileInput.files) {
                        const ext = file.name.split('.').pop().toLowerCase();
                        if (!validExtensions.includes(ext)) {
                            alert('拡張子が対応していません: ' + file.name);
                            fileInput.value = ''; // 入力リセット
                            break;
                        }
                    }
                });
            }
        });
        </script>


</body>
</html>
