<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class userRegisteredNotification extends Notification
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Регистрация в системе ОНМК')
            ->line('Добро пожаловать!')
            ->line('Ваш логин : ' . $this->user->login)
            ->line('Ваш пароль : ' . $this->user->passw)
            ->action('Войти на сайт', url('/'))
            ->line('Спасибо за регистрацию в нашей системе!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function handle(Registered $event)
    {
        if (!empty($event->user->mail)) {
            $event->user->notify(new userRegisteredNotification($event->user));
        }
    }
}
