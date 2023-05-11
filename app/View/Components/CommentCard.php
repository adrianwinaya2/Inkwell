<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CommentCard extends Component
{
    public $commenter;
    public $created;
    public $content;
    /**
     * Create a new component instance.
     */
    public function __construct($commenter, $created, $content)
    {
        $this->comment = $comment;
        $this->created_at = $created;
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comment');
    }
}
