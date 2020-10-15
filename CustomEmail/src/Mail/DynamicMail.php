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
    public $tokens, $template_type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tokens, $template_type)
    {
        $this->tokens = $tokens;
        $this->template_type = $template_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template = EmailTemplate::where('template_type', $this->template_type)->first();
        return $this->subject($template->subject)->markdown('customemail::emails.dynamicmail', [
            'template' => $template->template
        ]);
    }
}
