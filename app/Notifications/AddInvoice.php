<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddInvoice extends Notification
{
    use Queueable;
    private $invoice_id , $number;
    /**
     * Create a new notification instance.
     */
    public function __construct($invoice_id, $number)
    {
        $this -> invoice_id = $invoice_id;
        $this -> number = $number;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('printInvoice', $this -> invoice_id);

        return (new MailMessage)
                    ->greeting('Hello!')
                    ->subject('Payment Success!')
                    ->line('One of your invoices ('.$this -> number.') has been paid!')
                    ->action('Print Invoice', $url)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
