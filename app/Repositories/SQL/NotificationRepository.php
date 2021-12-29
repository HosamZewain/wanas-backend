<?php

namespace App\Repositories\SQL;

use App\Models\Notification;
use App\Models\User;
use App\Models\UserFcmToken;
use App\Repositories\Contracts\INotificationRepository;

class NotificationRepository extends AbstractModelRepository implements INotificationRepository
{

    private $SERVER_API_KEY;

    public function __construct(Notification $model)
    {
        parent::__construct($model);
        $this->SERVER_API_KEY = 'AAAAzCuqhw4:APA91bEdPdfkVspSWeSF60RKmz0IrtASyCz3eCpZWPPjbUdDrDdsQsTKOUHtoXM1yF12zifdiCx_cAcOiD7fOeJ3yq3ui4SXJKoo6zCBboM4nAVYqFstN7eUuqJKjJS7VebD386DxAob';
    }

    public function sendNotificationOld($user, $body = null, $title = 'Wanes', $paramters = [])
    {
        if (empty($user->fcmTokens)) {
            return false;
        }
        $users = [];

        info('token' . json_encode($user->fcmTokens));
        foreach ($user->fcmTokens as $token) {
            $users[] = $token['token'];
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
        info('users: ' . json_encode($users));
        $data = [
            "to" => $users,
            "registration_ids" => $users,
            "priority" => "high",
            "content_available" => true,
            "notification" => $notification,
            "data" => $notification,
        ];
        $dataString = json_encode($data);
        $notifications = Notification::create([
            'title' => $title,
            'body' => $body,
            'to_user' => $user->id,
            'type' => $paramters['type'],
            'from_user' => $paramters['member_id'] ?? null,
            'model_id' => $paramters['model_id'] ?? null,
            'model_type' => $paramters['model_type'] ?? null,
        ]);
        info('notifications: ' . json_encode($notifications));
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


    /**
     * @param $user
     * @param null $body
     * @param string $title
     * @param array $paramters
     * @return bool
     */
    final public function sendNotification($user, $body = null, string $title = 'Wanes', array $paramters = []): bool
    {
        $tokens = UserFcmToken::where('user_id', $user->id)->get();
        if (!count($tokens)) {
            return false;
        }

        info('users fcm tokens : ' . json_encode($tokens));
        $notification = [
            "title" => $title,
            "body" => $body,
        ];
        if (!empty($paramters)) {
            foreach ($paramters as $key => $value) {
                $notification[$key] = $value;
            }
        }
        foreach ($tokens as $token) {
            $data = [
                "to" => $token['token'],
               // "registration_ids" => $tokens->pluck('token')->toArray(),
                "priority" => "high",
                "content_available" => true,
                "notification" => $notification,
                "data" => $notification,
            ];
            $dataString = json_encode($data);
            $headers = [
                'Authorization: key=AAAAzCuqhw4:APA91bEdPdfkVspSWeSF60RKmz0IrtASyCz3eCpZWPPjbUdDrDdsQsTKOUHtoXM1yF12zifdiCx_cAcOiD7fOeJ3yq3ui4SXJKoo6zCBboM4nAVYqFstN7eUuqJKjJS7VebD386DxAob',
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
        }
        return true;
    }
}
