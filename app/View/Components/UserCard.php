<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class UserCard extends Component
{
    /**
     * $firstChirpDate
     *
     * Date of the users first chirp || null if user has no chirps
     */

    public $user;
    public $name;
    public $profileImageUrl;
    public $userChirpsCount;
    public $firstChirpDate;
    /**
     * Create a new component instance.
     */
    public function __construct($user)
    {
        // Assign User's Name
        $name = $user->name;
        $this->name = $name;

        // Assign Profile Image URL
        $profileImageUrl = $user->profile_image_url;
        $this->profileImageUrl = $profileImageUrl;

        // Assign Chirps Count
        $userChirpsCount = $user->chirps_count;
        $this->userChirpsCount = $userChirpsCount;

        // Assign First Chirp Date or Null (Set Via setFirstChirpDate)
        $firstChirp = $user->chirps->first();
        $this->firstChirpDate = $this->setFirstChirpDate($firstChirp);

        // Assign User
        $this->user = $user;

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
            $firstChirp =  date("M jS, Y", strtotime($firstChirp));
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
