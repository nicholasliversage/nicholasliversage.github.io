<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
class MailController extends Controller
{
    public function html_email() {
        $data = array('name'=>"Nicolas Liversage");
        Mail::send('inc.mail', $data, function($message) {
           $message->to('vergil99966@gmail.com', 'Novo Documento')->subject
              ('Entrada de novo documento');
           $message->from('nicolasliversage@gmail.com','Nicolas Liversage');
        });

        
        return redirect('/cliente')->with('success','A sua reclamacao foi enviada');
    }
}
