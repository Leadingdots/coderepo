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
    public $tokens, $template_type, $file_attachments;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tokens, $template_type, $file_attachments)
    {
        $this->tokens = $tokens;
        $this->file_attachments = $file_attachments;
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
            if($this->file_attachments && count($this->file_attachments)){
                foreach($this->file_attachments as $file_attachment){
                    $message->attachData(file_get_contents($file_attachment['data']), $file_attachment['name']);
                }
            }
            return $message;
        }else{
            return false;
        }
    }
}
