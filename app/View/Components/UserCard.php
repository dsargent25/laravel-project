<?php

namespace App\View\Components;

use Closure;
use App\Models\User;
use App\Models\Chirp;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class UserCard extends Component
{
    /**
     * $firstChirpDate
     *
     * Date of the users first chirp || null if user has no chirps
     */
    public $firstChirpDate;

    /**
     * Create a new component instance.
     */
    public function __construct(public User $user)
    {
        // assign user's first chirp
        $firstChirp = $user->chirps->first();

        $this->firstChirpDate = $this->setFirstChirpDate($firstChirp);

    }

    /**
     * setFirstChirpDate
     *
     * Format the User's first chirp created at date into Jan 2, 1990 format
     *
     * @param $firstChirp
     * @return string Datetime || null
     */
    public function setFirstChirpDate($firstChirp)
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
