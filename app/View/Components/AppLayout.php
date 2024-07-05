<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $loggedUser = Auth::user();
        $loggedUserRoleId = $loggedUser->role_id;
        
        return view('layouts.app', ['loggedUserRoleId' => $loggedUserRoleId]);
    }
}
