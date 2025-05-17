<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotify extends Notification implements ShouldQueue
{
    use Queueable;

    public $comment, $post;

    /**
     * Create a new notification instance.
     */
    public function __construct($comment, $post)
    {
        $this->comment = $comment;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [
            'user_id' => $this->comment->user_id,
            'user_name' => auth()->user()->name,
            'post_title' => $this->post->title,
            'comment' => $this->comment->comment,
            'post_slug' =>  $this->post->slug,
        ];
    }

    public function toBroadcast(object $notifiable)
    {
        return [
            'user_id' => $this->comment->user_id,
            'user_name' => auth()->user()->name,
            'post_title' => $this->post->title,
            'comment' => $this->comment->comment,
            'post_slug' =>  $this->post->slug,
        ];
    }
}
