<?php

namespace app\DefaultApp\Models;
use systeme\Model\Model;

class PushNotification extends Model
{
    public static function envoyer($deviceId, $title, $body, $data = [])
    {
        $data['date']=date("d-m-y H:i:s");
        $apiToken="AAAAk_iFjEs:APA91bFZeodTTAT9JSX9-dKYaHXAXo0eiixuDiAqf56q4miW9rz6bEt4gFqF8P0mxCaQHIOs1H2bULP023Z8Yrm_cYbp2ymAqj9KDbnjr9f5G8ZU2OBVMkD8UsiRz9IbHO9Kk1Aq2mrM";
        $senderId = "635529694283";
        $client = new \Fcm\FcmClient($apiToken, $senderId);
        $notification = new \Fcm\Push\Notification();
        $notification
            ->addRecipient($deviceId)
            ->setTitle($title)
            ->setBody($body)
            ->setSound("default")
            ->setBadge(3)
            ->addDataArray($data);
        $m = $client->send($notification);
        return $m;
    }

}
