<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navlink extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // Mengubah 'navlink' menjadi 'nav-link' sesuai dengan konvensi penamaan Blade Component
        // Laravel akan mencari file resources/views/components/nav-link.blade.php
        return view('components.nav-link');
    }
}