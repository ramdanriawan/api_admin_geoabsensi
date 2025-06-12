<?php

namespace App\View\Components\Web\Admin\Layout;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('web.admin.layouts.guest');
    }
}
