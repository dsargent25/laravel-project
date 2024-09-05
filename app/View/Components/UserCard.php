<?php

namespace App\View\Components;

use Closure;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserCard extends Component
{
    public $birthday;
    public $firstChirp;
    /**
     * Create a new component instance.
     */
    public function __construct(public User $user)
    {

        $this->firstChirp = $this->setFirstChirped($user->chirps->first());

    }

    public function setFirstChirped($firstChirp)
    {
        if ($firstChirp !== null ){
            $firstChirp = $firstChirp->created_at;
            $firstChirp =  date("l, F d, Y", strtotime($firstChirp));
            return $firstChirp;
        } else {
            return $firstChirp;
        }
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-card');
    }
}
