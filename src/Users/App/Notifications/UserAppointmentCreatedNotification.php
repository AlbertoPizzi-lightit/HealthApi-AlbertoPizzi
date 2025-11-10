<?php

declare(strict_types=1);

namespace Lightit\Users\App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Lightit\Users\Domain\Models\User;

class UserAppointmentCreatedNotification extends Notification implements ShouldQueue, ShouldBeEncrypted
{
    use Queueable;

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return new MailMessage()
            ->from('Alberto.pizzi@lightit.io', 'Ape')
            ->line("Dear, $notifiable->name, your appointment has been created successfully.")
            ->action('Your appointments!', url(''))
            ->line('Thank you for using our application!');
    }
}
