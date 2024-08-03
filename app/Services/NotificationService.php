<?php

namespace App\Services;

class NotificationService
{
    public static function notification($tokens, $title, $body)
    {

        $SERVER_API_KEY = 'AAAA_7zFrZw:APA91bFGbcBvqObE1PPMXofUgNCBD9nM_GC_mdbOOHeIgSDqvRUl9rrx_ibjFjRkVfNMcmhkafXZVesfMFu7o5Rg-zGL5tZYsXHnrUzGwmQRpVFTPoY62mB8A1m6qKIFEF-jFXRoiOU6';


        $data = [

            "registration_ids" => $tokens,

            "notification" => [

                "title" => $title,

                "body" => $body,

                "sound"=> "default" // required for sound on ios

            ],

        ];

        $dataString = json_encode($data);

        $headers = [

            'Authorization: key=' . $SERVER_API_KEY,

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

        //return $response;

    }
}
