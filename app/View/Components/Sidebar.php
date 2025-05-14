<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Sidebar extends Component
{
    public $userName;
    public $userRole;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($userName = null, $userRole = null)
    {
        $this->userName = $userName;
        $this->userRole = $userRole;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar');
    }
}