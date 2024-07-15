<?php

namespace App\Listeners;

use App\Events\CarCreated;
use App\Mail\CarAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
// use App\Jobs\ThrottledMail;

class NotifyAdminAboutNewCar
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CarCreated $event): void
    {
        User::getAdmins()->get()
        ->map(function (User $user){
            // ThrottledMail::dispatch(new CarAdded(), $user);
        });
    }
}
