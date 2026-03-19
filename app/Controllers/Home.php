<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    // Function untuk test Mailtrap
    public function testEmail()
    {
        $email = \Config\Services::email();

        $email->setTo('umairahsabri@ict4u.test'); 
        $email->setSubject('ICT4U - Testing Mailtrap Berjaya!');
        
        $message = "
            <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4;'>
                <h2 style='color: #333;'>Hello Umairah Sabri!</h2>
                <p>Kalau anda baca ni kat dashboard Mailtrap, maknanya config <b>Email.php</b> anda dah berjaya.</p>
                <p>Projek <b>ICT4U</b> dah ready untuk feature email!</p>
            </div>
        ";
        
        $email->setMessage($message);

        if ($email->send()) {
            return "✅ SUCCESS! Check dashboard Mailtrap";
        } else {
            return $email->printDebugger(['headers']);
        }
    }
}