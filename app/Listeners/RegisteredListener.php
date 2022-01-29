<?php

declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Mail\Mailer;
use App\Models\User;

class RegisteredListener
{
    private $mailer;
    private $eloquant; 

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer, User $eloquant)
    {
        $this->mailer = $mailer;
        $this->eloquant = $eloquant;
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $this->eloquant->findOrFail($event->user->getAuthIdentifier());
        $this->mailer->raw('会員登録完了しました', function ($message) use ($user){
            $message->subject('会員登録メール')->to($user->email);
        });
    }
}
