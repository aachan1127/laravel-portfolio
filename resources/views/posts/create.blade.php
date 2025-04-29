<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>

<body>
  <h1>投稿作成フォーム</h1>

  <form action="{{ route('posts.store') }}" method="POST">
    @csrf

    <div>
      <label for="title">タイトル</label>
      <input type="text" name="title" id="title" value="{{ old('title') }}">
    </div>

    <div>
      <label for="description">説明文</label>
      <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>
    </div>
    <div>
      <label for="url">URL</label>
      <input type="text" name="url" id="url" value="{{ old('url') }}">
    </div>


    <button type="submit">投稿する</button>
  </form>
</body>

</html>
