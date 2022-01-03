<?php

namespace App\Repositories\SQL;

use App\Models\Notification as NotificationModel;
use App\Models\User;
use App\Models\UserFcmToken;
use App\Repositories\Contracts\INotificationRepository;
use Pushok\AuthProvider;
use Pushok\Client;
use Pushok\InvalidPayloadException;
use Pushok\Notification;
use Pushok\Payload;
use Pushok\Payload\Alert;

class NotificationRepository extends AbstractModelRepository implements INotificationRepository
{

    private $SERVER_API_KEY;

    public function __construct(NotificationModel $model)
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


        $notifications = Notification::create([
            'title' => $title,
            'body' => $body,
            'to_user' => $user->id,
            'type' => $paramters['type'],
            'from_user' => $paramters['member_id'] ?? null,
            'model_id' => $paramters['model_id'] ?? null,
            'model_type' => $paramters['model_type'] ?? null,
        ]);
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
        //    curl_setopt($ch, CURLOPT_URL, "https://api.push.apple.com:443/3/device/" . $token['token']);
        //    //  curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
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

    /**
     * @throws InvalidPayloadException
     */
    public function sentAPNS($user, $body = null, string $title = 'Wanes', array $paramters = [])
    {
        $deviceTokens = UserFcmToken::where('user_id', $user->id)->get();
        if (!count($deviceTokens)) {
            return false;
        }
        $certificate_path = base_path('DistCert_R65MRFBR74.p12');

        $options = [
            'app_bundle_id' => 'com.roqay.wanas', // The bundle ID for app obtained from Apple developer account
            'certificate_path' => $certificate_path, // Path to private key
            'certificate_secret' => null // Private key secret
        ];
        // Be aware of thing that Token will stale after one hour, so you should generate it again.
        // Can be useful when trying to send pushes during long-running tasks
        $authProvider = AuthProvider\Certificate::create($options);

        $alert = Alert::create()->setTitle($title);
        $alert = $alert->setBody($body);

        $payload = Payload::create()->setAlert($alert);

        //set notification sound to default
        $payload->setSound('default');

        //add custom value to your notification, needs to be customized
        if (!empty($paramters)) {
            foreach ($paramters as $key => $value) {
                $payload->setCustomValue($key, $value);
            }
        }

//        $notifications = NotificationModel::create([
//            'title' => $title,
//            'body' => $body,
//            'to_user' => $user->id,
//            'type' => $paramters['type'] ?? null,
//            'from_user' => $paramters['member_id'] ?? null,
//            'model_id' => $paramters['model_id'] ?? null,
//            'model_type' => $paramters['model_type'] ?? null,
//        ]);

        foreach ($deviceTokens as $deviceToken) {
            $notifications[] = new Notification($payload, $deviceToken);
        }

        // If you have issues with ssl-verification, you can temporarily disable it. Please see attached note.
        // Disable ssl verification
        // $client = new Client($authProvider, $production = false, [CURLOPT_SSL_VERIFYPEER=>false] );
        $client = new Client($authProvider, $production = false);
        $client->addNotifications($notifications);


        $responses = $client->push(); // returns an array of ApnsResponseInterface (one Response per Notification)
        dd($responses);
        foreach ($responses as $response) {
            // The device token
            $response->getDeviceToken();
            // A canonical UUID that is the unique ID for the notification. E.g. 123e4567-e89b-12d3-a456-4266554400a0
            $response->getApnsId();

            // Status code. E.g. 200 (Success), 410 (The device token is no longer active for the topic.)
            $response->getStatusCode();
            // E.g. The device token is no longer active for the topic.
            $response->getReasonPhrase();
            // E.g. Unregistered
            $response->getErrorReason();
            // E.g. The device token is inactive for the specified topic.
            $response->getErrorDescription();
            $response->get410Timestamp();
        }
    }

    public function sendEXPO($user, $body = null, string $title = 'Wanes', array $paramters = [])
    {
        $deviceTokens = UserFcmToken::where('user_id', $user->id)->get();
        if (!count($deviceTokens)) {
            return false;
        }
        foreach ($deviceTokens as $deviceToken) {
            $payload = array(
                'to' => 'ExponentPushToken[' . $deviceToken['token'] . ']',
                'sound' => 'default',
                'title' => $title,
                'body' => $body,
            );
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://exp.host/--/api/v2/push/send",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => array(
                    "Accept: application/json",
                    "Accept-Encoding: gzip, deflate",
                    "Content-Type: application/json",
                    "cache-control: no-cache",
                    "host: exp.host"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
        }

    }

}
