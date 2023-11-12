<?php
namespace App\Notifications;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\MulticastSendReport;
use Kreait\Firebase\Messaging\SendReport;
use App\Models\FcmToken;
use Illuminate\Support\Facades\Http;
use Google\Client;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Exception\MessagingException;
use Illuminate\Support\Facades\Log;
use Symfony\Contracts\EventDispatcher\Event;

class FcmChannel 
{

    public function send($notifiable, Notification $notification): void
    {

    

        $data = $notification->toFcm($notifiable);

        $product = $data['product'];

        $fcmMessage = $data['message'];

        $tokens = $product->users()->pluck('fcm_token')->toArray();


        if(empty($tokens)){

            return;
        }
        
            
        try {

            $messaging  = Firebase::messaging(app_path('Files/google-services.json'));
            $message = CloudMessage::new()->withNotification($fcmMessage);

            $report = $messaging->sendMulticast($message,$tokens);

            $this->checkReportForFailures($notifiable,$notification,$report);

        }
        catch (MessagingException $e) {

            Log::alert($e->getMessage());
        }

    }


    /**
     * Handle the report for the notification and dispatch any failed notifications.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @param  Kreait\Firebase\Messaging\MulticastSendReport. $report
     * @return void
     */

 
    protected function checkReportForFailures($notifiable, $notification, MulticastSendReport $report)
    {
        collect($report->getItems())
            ->filter(fn (SendReport $report) => $report->isFailure())
            ->each(fn (SendReport $report) => $this->dispatchFailedNotification($notifiable, $notification, $report));
    }


     /**
     * Dispatch failed event.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @param  \Kreait\Firebase\Messaging\SendReport  $report
     * @return void
     */

    protected function dispatchFailedNotification($notifiable, Notification $notification, SendReport $report): void
    {

        event(new NotificationFailed($notifiable, $notification, self::class, [
            'report' => $report,
        ]));

    }
}