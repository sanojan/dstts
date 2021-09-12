<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateTask extends Notification
{
    use Queueable;
    protected $task, $history;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($task, $history)
    {
        $this->task = $task;
        $this->history = $history;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hello ' . $this->task->user->name . '!')
                    ->line('Your task for Letter No. ' . $this->task->letter->letter_no . ' has been ' . $this->history->status . ' by ' . $this->task->user->name)
                    ->action('View Task', url('/' . app()->getLocale() . '/tasks/' . $this->task->id))
                    ->line('Please do not reply to this mail, Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'task' => $this->task,
            'history' => $this->history
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
