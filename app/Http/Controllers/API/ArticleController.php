<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Events\ArticleCreated;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Notifications\ArticleCreatedNotification;

class ArticleController extends Controller
{
    public function index()
    {
        //$articles = Article::paginate(10);
        $articles = Cache::remember('articles_page_' . request('page', 1), 60, function () {
            return Article::paginate(10);
        });
        
        // Вместо return view()
        if (auth()->user()->role == 'moderator') {
            return response()->json(['status' => 'success', 'articles' => $articles]);
        }

        return response()->json(['status' => 'success', 'articles' => $articles]);
    }

    public function create()
    {
        $categories = Category::all(); // Получаем все категории

        // Вместо return view()
        return response()->json(['status' => 'success', 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'shortDesc' => 'required|string',
            'desc' => 'required|string',
        ]);

        $article = Article::create($request->all());
        Cache::forget('articles_page_' . request('page', 1));

        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new ArticleCreatedNotification($article));
        }
        broadcast(new ArticleCreated($article));

        // Вместо redirect()->route()
        return response()->json(['status' => 'success', 'message' => 'Новость создана.', 'article' => $article]);
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        if (auth()->user()->role == 'user') {
            $article->comments = $article->comments->where('approved', true);
        }
        
        auth()->user()->unreadNotifications
            ->where('data.id', $id)
            ->markAsRead();
         
        // Вместо return view()
        return response()->json(['status' => 'success', 'article' => $article]);
    }

    public function edit(Article $article)
    {
        // Вместо return view()
        return response()->json(['status' => 'success', 'article' => $article]);
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'shortDesc' => 'required|string',
        ]);

        $article->update($request->all());
        Cache::forget('article_' . $article->id);
        Cache::forget('articles_page_' . request('page', 1));

        // Вместо redirect()->route()
        return response()->json(['status' => 'success', 'message' => 'Новость обновлена.', 'article' => $article]);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        Cache::forget('article_' . $article->id);
        Cache::forget('articles_page_' . request('page', 1));

        // Вместо redirect()->route()
        return response()->json(['status' => 'success', 'message' => 'Новость удалена.']);
    }
}
