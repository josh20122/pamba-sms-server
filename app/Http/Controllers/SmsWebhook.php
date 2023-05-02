<?php

namespace App\Http\Controllers;

use AfricasTalking\SDK\AfricasTalking;
use App\Http\Controllers\Helper\AfricasTalkingHelper;
use App\Models\Message;
use App\Models\Record;
use Illuminate\Http\Request;

class SmsWebhook extends Controller
{
    public function register(Request $request){
        
        $data = $request->data;
        if($data==null){
            abort(419,'No data provided');
        }
        dd('success');
        $sms = json_decode($data);

        $saveThis =[
            'firstname'=>$sms->firstname,
            'lastname'=>$sms->lastname,
            'phone_number'=>$sms->phone_number,
            'gender'=>$sms->gender,
            'age'=>$sms->age,

            'region'=>$sms->region,
            'district'=>$sms->district,
            'ward'=>$sms->ward,
            'village'=>$sms->village,
            'sub_village'=>$sms->sub_village,
            'amcos'=>$sms->amcos,
            'amcos_physical_location'=>$sms->amcos_physical_location,

            'collector_name'=>$sms->collector_name,
            'collector_phone_number'=>$sms->collector_phone_number,
            'wheight'=>$sms->wheight,
            'price_per_kg'=>$sms->price_per_kg,
        ];
        
        Record::query()->create($saveThis);


        $message = $this->getDynamicNotificationMessageAttribute($sms);
        $message ='hello there';

        AfricasTalkingHelper::sendMessage('0758153416',$message,true);

        return response('Saved successfully.');
    }

 
    private function getDynamicNotificationMessageAttribute($sms){
     $message = Message::query()->where('action','like','sms-notification')->first()->message;
      if(strpos('[firstname]', $message)){
        $message = str_replace("[firstname]", $sms->firstname, $message);
      }
      if(strpos('[lastname]', $message)){
        $message = str_replace("[lastname]", $sms->lastname, $message);
      }
      if(strpos('[wheight]', $message)){
        $message  = str_replace("[wheight]", $sms->wheight, $message);
      }
      if(strpos('[priceperkg]', $message)){
        $message  = str_replace("[priceperkg]", $sms->price_per_kg, $message);
      }
      if(strpos('[totalprice]', $message)){
        $message = str_replace("[totalprice]", intval($sms->totalprice)*intval($sms->price_per_kg), $message);
      }

      return $message;
    }
}
