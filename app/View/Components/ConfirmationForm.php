<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConfirmationForm extends Component
{
    public $paragraph;
    /**
     * Create a new component instance.
     */
    public function __construct($paragraph)
    {
        $this->paragraph = $paragraph;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.confirmation-form');
    }
}
