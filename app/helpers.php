<?php

use Illuminate\Support\Facades\Log;

function sendNotification($alert, $device_token)
{
    $firebaseKey =  env("FIREBASE_API_KEY");

    $firebase_url="https://fcm.googleapis.com/fcm/send";

    $headers = array(
        'Authorization: key=' . $firebaseKey,
        'Content-Type: application/json',
    );
    if (!count($device_token)) {
        return false;
    }
    $notification  = [
        'data' => [
            'title' => $alert->title,
            'message' => $alert->short_description,
            //'image' => '' //image file path
        ]
    ];
    
    $fields = array(
        'registration_ids' => $device_token,
        'data'             => $notification
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $firebase_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $result = curl_exec($ch);
    if ($result === false) {
        die('Curl failed: ' . curl_error($ch));
    }
    // dd($result);
    curl_close($ch);
    Log::info('result of push notifications '.print_r($result,true).PHP_EOL);
    return $result;
    
}

?>