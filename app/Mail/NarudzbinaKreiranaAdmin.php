<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NarudzbinaKreiranaAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $narudzbina;

    public function __construct($narudzbina)
    {
        $this->narudzbina = $narudzbina;
    }

    public function build()
    {
        return $this->subject('Nova narudžbina na sajtu')
            ->markdown('emails.narudzbina.admin');
    }
}