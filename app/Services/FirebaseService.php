<?php
namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Exception;

class FirebaseService
{
protected $messaging;

public function __construct()
{
$serviceAccountPath = config('services.firebase.credentials');

if (empty($serviceAccountPath) || !file_exists($serviceAccountPath)) {
throw new Exception('Firebase credentials path is not set or file does not exist.');
}

$firebase = (new Factory)
->withServiceAccount($serviceAccountPath);

$this->messaging = $firebase->createMessaging();
}

public function sendNotification($deviceToken, $title, $body)
{
$notification = Notification::create($title, $body);
$message = CloudMessage::withTarget('token', $deviceToken)
->withNotification($notification);

$this->messaging->send($message);
}
}
