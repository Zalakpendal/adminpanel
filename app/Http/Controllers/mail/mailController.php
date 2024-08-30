<?php

namespace App\Http\Controllers\mail;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class mailController extends Controller
{
    function sendEmail()
    {
        // return "email send ";
        $to="zalakpendal01@gmail.com";
        $msg="heyy welcome from zalak how may i help you ??";
        $subject="test email";
        Mail::to($to)->send(new WelcomeEmail($msg,$subject));
    }
    
}
