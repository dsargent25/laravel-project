<?php

namespace App\View\Components\Chirp;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChirpComment extends Component
{

    public $comment;

    public function __construct($comment)
    {
        //A Comment and its Attributes
        $this->comment = $comment;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chirp.chirp-comment');
    }
}
