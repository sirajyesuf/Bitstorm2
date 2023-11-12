<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Product;
use App\Notifications\FcmChannel;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

class ProductDiscountPushNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $body;
    protected Product  $product;

   
    public function __construct($product,$title,$body)
    {
        $this->title = $title;
        $this->body = $body;
        $this->product = $product;
    }

    public function via(object $notifiable): array
    {
        return [FcmChannel::class,'database'];
    }


    public function toFcm($notifiable){


        
        return [
           "message" =>  FirebaseNotification::create($this->title,$this->body),
           'product'      => $this->product
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body
        ];
    }

}
