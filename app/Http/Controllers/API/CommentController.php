<?php

namespace App\Http\Controllers\API;

use App\Mail\NewCommentMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Comment;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\VeryLongJob;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'content' => 'required|max:1000',
        ]);

        $comment = $article->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);

        // Отправляем email всем модераторам
        $moderators = User::where('role', 'moderator')->get();

        foreach ($moderators as $moderator) {
            Mail::to($moderator->email)->send(new NewCommentMail($comment));
        }

        // Запускаем долгую задачу в очередь
        VeryLongJob::dispatch($comment);

        // Возвращаем JSON-ответ
        return response()->json([
            'status' => 'success',
            'message' => 'Комментарий отправлен на модерацию.',
            'comment' => $comment
        ]);
    }

    public function approve($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->update(['approved' => true]);

        // Возвращаем JSON-ответ
        return response()->json([
            'status' => 'success',
            'message' => 'Комментарий одобрен',
            'comment' => $comment
        ]);
    }

    public function reject($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->delete();

        // Возвращаем JSON-ответ
        return response()->json([
            'status' => 'success',
            'message' => 'Комментарий отклонен'
        ]);
    }

    public function moderate(Comment $comment, $action)
    {
        if (!auth()->user()->isModerator()) {
            abort(403);
        }

        $comment->approved = $action === 'approve';
        $comment->save();

        // Возвращаем JSON-ответ
        return response()->json([
            'status' => 'success',
            'message' => 'Комментарий обновлен',
            'comment' => $comment
        ]);
    }
}
