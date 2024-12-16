<!DOCTYPE html>
<html>
<head>
    <title>Новый комментарий</title>
</head>
<body>
    <h1>Новый комментарий на вашу статью</h1>
    <p>Комментарий: {{ $comment->content }}</p>
    <p>Перейти к статье: <a href="{{ url('/articles/'.$comment->article_id) }}">Открыть статью</a></p>
</body>
</html>
