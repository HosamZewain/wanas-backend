<?php

namespace App\Repositories\SQL;

use App\Models\Notification;
use App\Repositories\Contracts\INotificationRepository;

class NotificationRepository extends AbstractModelRepository implements INotificationRepository
{

    private $SERVER_API_KEY;

    public function __construct(Notification $model)
    {
        parent::__construct($model);
        $this->SERVER_API_KEY = 'AAAAzCuqhw4:APA91bEdPdfkVspSWeSF60RKmz0IrtASyCz3eCpZWPPjbUdDrDdsQsTKOUHtoXM1yF12zifdiCx_cAcOiD7fOeJ3yq3ui4SXJKoo6zCBboM4nAVYqFstN7eUuqJKjJS7VebD386DxAob';
    }

    public function sendNotification($user, $body = null, $title = 'Wanes', $paramters = [])
    {
        if (empty($user->fcmTokens)) {
            return false;
        }
        $users = [];
        foreach ($user->fcmTokens as $token) {
            $users[] = $token;
        }
        $notification = [
            "title" => $title,
            "body" => $body,
        ];
        if (!empty($paramters)) {
            foreach ($paramters as $key => $value) {
                $notification[$key] = $value;
            }
        }
        $data = [
            "to" => $users,
            "priority" => "high",
            "content_available" => true,
            "notification" => $notification,
            "data" => $notification,
        ];
        $dataString = json_encode($data);
        Notification::create([
            'title' => $title,
            'body' => $body,
            'to_user' => $user->id,
            'type' => $paramters['type'],
            'from_user' => $paramters['member_id'] ?? null,
            'model_id' => $paramters['model_id'] ?? null,
            'model_type' => $paramters['model_type'] ?? null,
        ]);
        $headers = [
            'Authorization: key=' . $this->SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        info($response);
        return $response;
    }
}
