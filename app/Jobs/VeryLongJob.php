<?php

namespace App\Jobs;

use App\Mail\NewCommentMail;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class VeryLongJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;

    // Конструктор для передачи данных в задание
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    // Метод обработки задания
    public function handle(Mailer $mailer)
    {
        // Получаем модератора
        $moderator = User::where('role', 'moderator')->first();
        
        // Отправляем письмо
        $mailer->to($moderator->email)->send(new NewCommentMail($this->comment));
    }
}
