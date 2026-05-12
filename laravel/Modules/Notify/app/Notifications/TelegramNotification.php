<?php

declare(strict_types=1);

/**
 * @see https://iftikhar-ahmed.medium.com/send-push-notifications-in-laravel-using-firebase-on-your-android-device-f585621db900
 * @see https://github.com/laravel-notification-channels/telegram
 */

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\TelegramChannel;

/**
 * Classe per inviare notifiche tramite Telegram.
 */
class TelegramNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $message;

    protected array $options;

    /**
     * Create a new notification instance.
     *
     * @param  string  $message  Il messaggio da inviare tramite Telegram
     * @param  array<string, mixed>  $options  Opzioni aggiuntive per la notifica
     */
    public function __construct(string $message, array $options = [])
    {
        $this->message = $message;
        $this->options = $options;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $_notifiable  The entity to be notified (l'entità da notificare)
     * @return array<int, class-string>
     */
<<<<<<< HEAD
    public function via($_notifiable): array
=======
    public function via(mixed $_notifiable): array
>>>>>>> laraxot/dev
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  object|null  $notifiable  The entity to be notified
     * @return array<string, mixed>
     */
    public function toArray(?object $notifiable): array
    {
        // return $this->data->toArray();
        return [];
    }

    /**
     * Get the Telegram representation of the notification.
<<<<<<< HEAD
     *
     * @param  mixed  $notifiable
     */
    public function toTelegram($notifiable): string
=======
     */
    public function toTelegram(mixed $notifiable): string
>>>>>>> laraxot/dev
    {
        return $this->message;
    }
}
