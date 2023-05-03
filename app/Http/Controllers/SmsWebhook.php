<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use App\Http\Controllers\Helper\AfricasTalkingHelper;
use App\Models\Message;
use App\Models\Record;
use Exception;
use Illuminate\Http\Request;

class SmsWebhook extends Controller
{
  public function register(Request $request)
  {
    $smsData = $request->getContent();

    $sms = explode(',', $smsData);


    try {
      $saveThis = [
        'firstname' => $sms[0],
        'lastname' => $sms[1],
        'phone_number' => $sms[2],
        'gender' => $sms[3],
        'age' => $sms[4],
        'village' => $sms[5],
        'sub_village' => $sms[6],
        'collector_name' => $sms[7],
        'collector_phone_number' => $sms[8],
        'wheight' => $sms[9],
        'price_per_kg' => $sms[10],
      ];
    } catch (\Exception $e) {
      return response('Unauthorized', 401);
    }


    Record::query()->create($saveThis);


    $message = $this->getDynamicNotificationMessageAttribute($sms);

    AfricasTalkingHelper::sendMessage($sms[2], $message, true);

    return response('Sweet success');
  }


  private function getDynamicNotificationMessageAttribute($sms)
  {

    $message = Message::query()->where('action', 'like', 'sms-notification')->first()->message;
    if (strpos($message, '[firstname]') !== false) {
      $message = str_replace("[firstname]", $sms[0], $message);
    }
    if (strpos($message, '[lastname]') !== false) {
      $message = str_replace("[lastname]", $sms[1], $message);
    }
    if (strpos($message, '[wheight]') !== false) {
      $message = str_replace("[wheight]", $sms[9], $message);
    }
    if (strpos($message, '[priceperkg]') !== false) {
      $message = str_replace("[priceperkg]", $sms[10], $message);
    }
    if (strpos($message, '[totalprice]') !== false) {
      $message = str_replace("[totalprice]", intval($sms[9]) * intval($sms[10]), $message);
    }

    return $message;
  }
}