<?php

use App\Mail\TestResend;
use App\Models\Property;
use App\Models\User;
use App\Models\VisitRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\PasswordResetLinkSent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    // $user = User::first();
    // Mail::raw('This is a test email', function ($message) use ($user) {
    //     $message->to('musabgaili@gmail.com')
    //             ->subject('Test Email')
    //             ->from('hello@musab.link');
    // });
    // return 'done';
    return redirect()->away('https://doorstepview.com/');


});
