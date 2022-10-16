<?php

namespace App\Traits;

use App\Mail\NotificationMail;
use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

trait NotificationTrait
{
    /**
     * Send notification via multiple channels
     *
     * @param string $channels example: email,whatsapp,sms
     * @param User $user
     * @param string $title
     * @param string $message
     * @param array $metadata
     * @return integer
     */
    public function notify($channels = 'email', $user, $title, $message, $metadata = [])
    {
        try {
            foreach (explode(',', $channels) as $channel) {
                if ($channel == 'whatsapp') {
                    $this->sendWhatsapp($user, $title, $message, $metadata);
                }  elseif ($channel == 'sms') {
                    $this->sendSms($user, $title, $message, $metadata);
                } else {
                    $this->sendEmail($user, $title, $message, $metadata);
                }
            }
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return 1;
        }
        
        return 0;
    }
    
    public function sendEmail($user, $title, $message, $metadata = [])
    {
        Mail::to($user)->send(new NotificationMail($user, $title, $message, $metadata));
    }

    public function sendWhatsapp($user, $title, $message, $metadata = [])
    {
        # code...
        
    }

    public function sendSms($annonce_user)
    {
        # code...
        $this->sendCustomMessage($annonce_user);
    }

    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            $recipients,
            ['from' => $twilio_number, 'body' => $message]
        );
    }

    public function sendCustomMessage($annonce_user)
    {
        try
        {

            $recipients = $annonce_user->Phone;

            
            $this->sendMessage(
              "Bonjour , Vous êtes approuvé! Cliquer sur le lien suivant: "+ $annonce_user->Phone,
               $recipients
            ); 


          return back()->with(['success' => "Messages on their way!"]);

        }
        catch(\Throwable $th)
        {

             Log::info($th->getMessage());
             return 1;  

        }
       
     
    }
}
