<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use JsonException;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class FcmNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private mixed $data;
    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return [FcmChannel::class];
    }

    /**
     * @throws CouldNotSendNotification|JsonException
     */
    public function toFcm($notifiable): FcmMessage
    {
        $title = $this->data['title'];
        $body = $this->data['body'];
        $data = $this->handlingNotificationData();
        return FcmMessage::create()
            ->setData($data)
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle($title)
                ->setBody($body)
                ->setImage(asset('/UI/assets/images/roqay-notification.svg')))
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
    }

    /**
     * @throws JsonException
     */
    private function handlingNotificationData(): array
    {
        $data = $this->data;
        $actionsData = isset($data['data']['actions']) ? $this->convertActionDataToJson() : [];
        return $data['data'] ? array_merge($data['data'], $actionsData): [];
    }

    /**
     * @throws JsonException
     */
    private function convertActionDataToJson(): array
    {
        $actionsData = [];
        $actionsData['actions'] = json_encode(array_map('json_encode', $this->data['data']['actions']), JSON_THROW_ON_ERROR);
        $actionsData['actionsEnabled'] = json_encode($this->data['data']['actionsEnabled'], JSON_THROW_ON_ERROR);
        $actionsData['permission'] = $this->data['data']['permission'];
        return $actionsData;
    }

}
