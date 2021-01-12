<?php

namespace Leadingdots\CustomEmail\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Leadingdots\CustomEmail\Models\EmailTemplate;

class DynamicMail extends Mailable
{
    use Queueable, SerializesModels;
    public $tokens, $template_type, $attachments;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tokens, $template_type, $attachments)
    {
        $this->tokens = $tokens;
        $this->attachments = $attachments;
        $this->template_type = $template_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template = EmailTemplate::where('template_type', $this->template_type)->where('status', '1')->first();
        $subject = $template->subject;
        foreach($this->tokens as $key => $token){
            $subject = str_replace('#'.$key.'#',$token,$subject);
        }
        if($template){
           $message = $this->subject($subject)->markdown('customemail::emails.dynamicmail', [
                'template' => $template->template
            ]);
            if($this->attachments && count($this->attachments)){
                foreach($this->attachments as $attach){
                    $message->attach($attach);
                }
            }
            return $message;
        }else{
            return false;
        }
    }
}
