<?php

namespace App\Notifications;

use App\Channels\Messages\WhatsAppMessage;
use App\Channels\WhatsAppChannel;
use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeadConnect extends Notification
{
    use Queueable;

    public $lead;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
        $company = 'LASIK';
        $appointmentDate = now()->toFormattedDateString();

        return (new WhatsAppMessage)
//            ->content("Your {$company} appointment is coming up on {$appointmentDate}");
//            ->content("Your {$company} order of {$company} has shipped and should be delivered on {$appointmentDate}. Details: {$company}");
            ->content("Your {$company} code is 123456");
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');
//    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
//    public function toArray($notifiable)
//    {
//        return [
//            //
//        ];
//    }
}
