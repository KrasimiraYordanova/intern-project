<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function deleting(User $user): void
    {

        // dd('I am being deleted');
        $user->cars()->delete();
        $user->properties()->delete();
    }
}
