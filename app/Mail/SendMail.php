<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
	
	public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    if($this->data['type']=='forgot_password'){
		return $this->from($this->data['from'])
		            ->subject($this->data['subject'])
					->view('dynamic_email_template')
					->with('data', $this->data);
					
					}else{
					return $this->from($this->data['from'])
		            ->subject($this->data['subject'])
					->attach(public_path('/pdf/').$this->data['filename'], array(
					'as' => $this->data['filename'], 
					'mime' => 'application/pdf'))
					->view('dynamic_email_template')
					->with('data', $this->data);
					}
    }
}
