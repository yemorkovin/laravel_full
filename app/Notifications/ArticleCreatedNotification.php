<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification; 

class ArticleCreatedNotification extends Notification
{
    use Queueable;

    public $article;

    public function __construct($article)
    {
        $this->article = $article;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->article->name,
            'id' => $this->article->id,
        ];
    }
}
