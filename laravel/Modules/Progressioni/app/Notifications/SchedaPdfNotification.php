<?php

declare(strict_types=1);

namespace Modules\Progressioni\Notifications;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Modules\Progressioni\Emails\SchedaPdfMail;
use Modules\Progressioni\Models\Schede;

class SchedaPdfNotification extends Notification
{
    use Queueable;

    public Schede $model;

    /**
     * Create a new notification instance.
     */
    public function __construct(Schede $model)
    {
        $this->model = $model;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        if (($this->model->email ?? null) === null) {
            throw new Exception('property [email] not exits in ['.$this->model::class.']');
        }

        Mail::to([$this->model->email])->send(new SchedaPdfMail($this->model));

        return (new MailMessage)
            ->line('PDF per scheda '.$this->model->cognome.' '.$this->model->nome.' è stato inviato.')
            ->line('Grazie per aver utilizzato la nostra applicazione!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(mixed $notifiable): array
    {
        return [
        ];
    }
}
