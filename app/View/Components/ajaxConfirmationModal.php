<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ajaxConfirmationModal extends Component
{
    public $href;
    public function __construct($href)
    {
        $this->href = $href;
    }

    public function render(): View|Closure|string
    {
        return view('components.ajax-confirmation-modal');
    }
}
