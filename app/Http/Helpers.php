<?php

namespace App\Http;

use Illuminate\Support\Facades\Mail;

class Helpers
{
    public static function combineArray($collection)
    {
        $temp = array();
        foreach ($collection as $collect) {
            $temp = array_add($temp, $collect->id, $collect->name);
        }
        return $temp;
    }

    public static function sendEmail($receiverEmail, $receiverName, $subject, $content , $emailTemplate, $cc = null)
    {

        Mail::send($emailTemplate, ['receiverEmail' => $receiverEmail,'receiverName' => $receiverName, 'subject'=>$subject,'content' => $content,'cc'=>$cc], function ($mail) use ($receiverEmail,$receiverName,$subject,$content,$cc) {
            $mail->from('arplatform@support.com', '思購易AR');
            $mail->to($receiverEmail, $receiverName)->subject($subject);
            if(isset($cc)){
                $mail->cc($cc);
            }
        });
    }

//    public static function sendEmail($user, $issue_id, $subject, $emailTemplate, $cc = null)
//    {
//
//        Mail::send($emailTemplate, ['user' => $user, 'issue_id' => $issue_id,'subject'=>$subject,'cc'=>$cc], function ($mail) use ($user, $issue_id,$subject,$cc) {
//            $mail->from('issuetrackingsystem@support.com', 'admin');
//            $mail->to($user->email, $user->name)->subject($subject);
//            if(isset($cc)){
//                $mail->cc($cc);
//            }
//        });
//    }
}



