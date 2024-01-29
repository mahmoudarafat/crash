<?php


use App\Livewire\Posts\CreatePost;
use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

it('can save a book', function () {
    // Assuming you have Livewire component and routes properly set up
    Livewire::test(CreatePost::class)
        ->set('title', 'my title')
        ->set('author', 'the author')
        ->set('content', 'this is contetn')
        ->set('image', null)
        ->call('save');

    // Add assertions based on your application's logic
    $this->assertDatabaseHas('posts', ['title' => 'my title', 'author' => 'the author']);
});


it('can save a book with image', function () {
    // Assuming you have Livewire component and routes properly set up
    Livewire::test(CreatePost::class)
        ->set('title', 'my title2')
        ->set('author', 'the author')
        ->set('content', 'this is contetn')
        ->set('image', UploadedFile::fake()->image('test-image.jpg'))
        ->call('save');

    // Add assertions based on your application's logic
    $this->assertDatabaseHas('posts', ['title' => 'my title2', 'author' => 'the author']);

    
    // Get the saved contact from the database
    $post = Post::where('title', 'my title2')->first();

    // Assert that the attachment file exists
    $this->assertFileExists(public_path('storage/' . $post->image));


});


it('validates required fields', function () {
    Livewire::test(CreatePost::class)
        ->call('save')
        ->assertHasErrors(['title', 'author', 'content']);
});


it('validates image format', function () {
    Livewire::test(CreatePost::class)
        // ->set('title', 'my title')
        ->set('title', rand())
        ->set('author', 'the author')
        // ->set('content', 'this is contetn')
        ->set('image', 'invalid-image-format')
        ->call('save')
        ->assertHasErrors(['image']);
});

it('validates unique title', function () {
    // Assuming you have a user with the same email in the database
    Livewire::test(CreatePost::class)
        ->set('title', 'my title')
        ->set('author', 'the author')
        ->set('content', 'this is contetn')
        ->call('save');

    Livewire::test(CreatePost::class)
        ->set('title', 'my title')
        ->call('save')
        ->assertHasErrors(['title']);
});
