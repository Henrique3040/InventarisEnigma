<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Producten;


class ProductStockLevelNotification extends Notification
{
    use Queueable;

    protected $product;
    protected $level;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Producten $product, $level)
    {
        $this->product = Producten::find($product->id);
        $this->level = 'under';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
   {
    $subject = $this->level == 'over' ? 'Product Stock Above 5 Units' : 'Product Stock Below 5 Units';

    return (new MailMessage)
                ->subject($subject)
                ->greeting('Hello!')
                ->line("The stock level for the product '{$this->product->product_name}' has gone {$this->level} 5 units.")
                ->line("Current stock level: {$this->product->quantity}")
                ->action('View Product', url('/producten/'.$this->product->id))
                ->line('Thank you for using our application!');
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
