<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;

class Iteration extends Component
{
    public $posts;
    public function render()
    {

        return view('livewire.Posts.iteration');
    }

    public function mount()
    {
        // Initialize $yourVariable here
        $this->posts = Post::all(); // Example, replace with your logic
    }
}
