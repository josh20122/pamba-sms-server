<?php

namespace App\Http\Controllers\Helper;

use AfricasTalking\SDK\AfricasTalking;
use App\Models\Api;
use App\Models\Message;
use App\Models\MessageNotification;
use App\Models\User;
use Exception;


class AfricasTalkingHelper
{
    public function __construct()
    {
        $this->setAuth();
    }

    public static function sendMessage($recipients, $message, $advert = false, $sender = null)
    {
        $from = (new self)->from ? (new self)->from : null;
        $sms = self::sms();
        try {
            // Thats it, hit send and we'll take care of the rest
            $result = $sms->send([
                'to' => $recipients,
                'message' => $message,
                'from' => $from,
            ]);
            $json = json_encode($result, true);

            $sentMessages = json_decode($json)->data->SMSMessageData->Recipients;
            if ($advert === true) {
                (new self)->recordMessage($sentMessages, $message, $sender);
            }
            return $sentMessages;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    private function recordMessage($recipients, $message, $sender)
    {
        foreach ($recipients as $to) {
            MessageNotification::query()->create([
                'number' => $to->number,
                'message' => $message,
                'status' => $to->status,
                'cost' => $to->cost,
            ]);
        }
        return true;
    }

    private static function sms()
    {
        $apiKey = (new self)->apiKey;
        $username = (new self)->username;
        $AT = new AfricasTalking($username, $apiKey);
        $sms = $AT->sms();
        return $sms;
    }

    private function setAuth()
    {
        $api = Api::get(['value', 'type']);
        foreach ($api as $credential) {
            if ($credential->type === 'apiKey')
                $this->apiKey = $credential->value;
            else if ($credential->type === 'username')
                $this->username = $credential->value;
            else if ($credential->type === 'from')
                $this->from = $credential->value;
        }
    }
    private $to;
    private $from;
    private $apiKey;
    private $username;
    protected $sender;
}