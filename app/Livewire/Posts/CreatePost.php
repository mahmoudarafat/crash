<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{

    use WithFileUploads;
    
    public $title;
    public $author;
    public $content;
    public $image;

    public function render()
    {
        return view('livewire.posts.create-post');
    }

    public function save(){

         // Validate the input
         $this->validate([
            'title' => 'required|unique:posts,title',
            'author' => 'required',
            'content' => 'required',
            'image' => 'nullable|image'
        ]);
        $path = null;
        if ($this->image) {
            $path = $this->image->store('uploads', 'public');
            // Save the file path or perform other actions with the uploaded file
        }

        $post = Post::create([
            'title' => $this->title,
            'author' => $this->author,
            'content' => $this->content,
            'image' => $path,
        ]);

        // Reset the form fields
        $this->reset(['content', 'author', 'title', 'image']);

        // You can add a success message or any other feedback here
        session()->flash('message', 'Post saved successfully.');
        
        return redirect()->to('/books')
             ->with('status', 'Post created!');
    }


}
