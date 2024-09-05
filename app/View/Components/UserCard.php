<?php

namespace App\View\Components;

use Closure;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserCard extends Component
{
    public $birthday;
    /**
     * Create a new component instance.
     */
    public function __construct(public User $user)
    {
        $this->birthday = $this->setBirthday($user->created_at);
    }

    public function setBirthday($createdAt)
    {
        $properDate =  date("l, F d, Y", strtotime($createdAt));  
        return $properDate;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-card');
    }
}
