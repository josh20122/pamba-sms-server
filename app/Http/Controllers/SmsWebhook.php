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
    $string = $request->getContent();
    $decodedString = urldecode($string);
    $sms = json_decode(substr($decodedString, 5));

    if ($string == null) {
      abort(401, 'No data provided');
    }

    try {
      $saveThis = [
        'firstname' => $sms->firstname,
        'lastname' => $sms->lastname,
        'phone_number' => $sms->phone_number,
        'gender' => $sms->gender,
        'age' => $sms->age,

        'region' => $sms->region,
        'district' => $sms->district,
        'ward' => $sms->ward,
        'village' => $sms->village,
        'sub_village' => $sms->sub_village,
        'amcos' => $sms->amcos,
        'amcos_physical_location' => $sms->amcos_physical_location,

        'collector_name' => $sms->collector_name,
        'collector_phone_number' => $sms->collector_phone_number,
        'wheight' => $sms->wheight,
        'price_per_kg' => $sms->price_per_kg,
      ];
    } catch (\Exception $e) {
      return response('Unauthorized', 401);
    }


    Record::query()->create($saveThis);


    $message = $this->getDynamicNotificationMessageAttribute($sms);

    AfricasTalkingHelper::sendMessage($sms->phone_number, $message, true);

    return response('Sweet success');
  }


  private function getDynamicNotificationMessageAttribute($sms)
  {

    $message = Message::query()->where('action', 'like', 'sms-notification')->first()->message;
    if (strpos($message, '[firstname]') !== false) {
      $message = str_replace("[firstname]", $sms->firstname, $message);
    }
    if (strpos($message, '[lastname]') !== false) {
      $message = str_replace("[lastname]", $sms->lastname, $message);
    }
    if (strpos($message, '[wheight]') !== false) {
      $message = str_replace("[wheight]", $sms->wheight, $message);
    }
    if (strpos($message, '[priceperkg]') !== false) {
      $message = str_replace("[priceperkg]", $sms->price_per_kg, $message);
    }
    if (strpos($message, '[totalprice]') !== false) {
      $message = str_replace("[totalprice]", intval($sms->totalprice) * intval($sms->price_per_kg), $message);
    }

    return $message;
  }
}