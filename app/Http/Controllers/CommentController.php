<?php
namespace App\Http\Controllers;
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
      

        $moderators = User::where('role', 'moderator')->get();

        foreach ($moderators as $moderator) {
            Mail::to($moderator->email)->send(new NewCommentMail($comment));
        }

        VeryLongJob::dispatch($comment);

        return redirect()->back()->with('success', 'Комментарий отправлен на модерацию.');
    }
    public function approve($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->update(['approved' => true]);

        return redirect()->back()->with('success', 'Комментарий одобрен');
    }

    public function reject($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->delete();

        return redirect()->back()->with('success', 'Комментарий отклонен');
    }
    
    public function moderate(Comment $comment, $action)
    {
        if (!auth()->user()->isModerator()) {
            abort(403);
        }

        $comment->approved = $action === 'approve';
        $comment->save();

        return redirect()->back()->with('success', 'Комментарий обновлен.');
    }
}
