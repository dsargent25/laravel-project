<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserFollowButton extends Component
{
    public $user;
    public $name;
    public $id;
    /**
     * Create a new component instance.
     */
    public function __construct($user)
    {
        $name = $user->name;
        $this->name = $name;

        $id = $user->id;
        $this->id = $id;

        $this->user = $user;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-follow-button');
    }
}
