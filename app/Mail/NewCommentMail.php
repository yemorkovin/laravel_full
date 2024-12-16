<?php
namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCommentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;

    // Конструктор для передачи данных в почтовое уведомление
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    // Метод для настройки письма
    public function build()
    {
        return $this->subject('Новый комментарий на вашем сайте')
                    ->view('emails.new_comment')
                    ->with([
                        'comment' => $this->comment
                    ]); 
    }
}
