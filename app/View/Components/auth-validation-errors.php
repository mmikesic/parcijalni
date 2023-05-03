<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AuthValidationErrors extends Component
{
    /**
     * The error bag instance.
     *
     * @var string
     */
    public $bag;

    /**
     * Create a new component instance.
     *
     * @param  string|null  $bag
     * @return void
     */
    public function __construct($bag = null)
    {
        $this->bag = $bag ?? 'default';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.auth-validation-errors');
    }
}
