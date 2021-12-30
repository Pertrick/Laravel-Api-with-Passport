<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $data  = ['name' => $event->user->name,
            'email' => $event->user->email,
            'body' => 'Welcome to our website. Hope you will enjoy our articles'];

        Mail::send('email.mail', $data, function($message) use ($data){
            $message->to($data['email'])
                ->subject('Welcome to our Blog');

            $message->from('noreply@patrickudoh.com');
        });
    }
}
