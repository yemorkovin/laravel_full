<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\LogArticleView;


Route::get('/', [MainController::class, 'index'])->name('home');

Route::get('/about', [MainController::class, 'about'])->name('about');
Route::get('/contact', [MainController::class, 'contact'])->name('contact');
Route::get('/galery/{id}', [MainController::class, 'galery'])->name('galery');
Route::post('/contact', [MainController::class, 'storeContact'])->name('contact.store');


Route::post('/article/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::patch('/comments/{comment}/{action}', [CommentController::class, 'moderate'])->name('comments.moderate');

Route::get('signin', [AuthController::class, 'create'])->name('create.form');
Route::post('signin', [AuthController::class, 'registration'])->name('registration');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
//Route::middleware(['log.article.view'])->group(function () {
    // Маршрут для просмотра статьи
  //  Route::get('/article/{id}', [ArticleController::class, 'show'])->name('article.show');
//});
Route::middleware([LogArticleView::class])->group(function () {
    Route::resource('article', ArticleController::class);
    //Route::resource('article', ArticleController::class)->middleware('log.article.view');

});


Route::post('comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
Route::post('comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');

