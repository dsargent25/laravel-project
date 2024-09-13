<?php

namespace App\View\Components\Chirps;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChirpCard extends Component
{

    public $chirp;

    public $name;
    public $profileImageUrl;
    public $message;
    public $chirpCreatedDate;

    public function __construct($chirp)
    {

        // Chirp
        $this->chirp = $chirp;

        // Assign User's Name
        $name = $chirp->user->name;
        $this->name = $name;

        // Assign Profile Image URL
        $profileImageUrl = $chirp->user->profile_image_url;
        $this->profileImageUrl = $profileImageUrl;

        // Assign Message
        $message = $chirp->message;
        $this->message = $message;

        // Chirp Created Date
        $chirpCreatedDate = $chirp->created_at->format('M jS, Y');
        $this->chirpCreatedDate = $chirpCreatedDate;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chirps.chirp-card');
    }
}
