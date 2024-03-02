<?php


use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

beforeEach(function () {
    // $this->user = User::factory()->create();
    $this->actingAs(User::factory()->create());
});

echo "this is from api namespace";

it('can save a book', function () {
    // Assuming you have Livewire component and routes properly set up
    // $this->actingAs(User::factory()->create());
    $response = $this->postJson('/save-book', [
        'title' => 'my title',
        'author' => 'the author',
        'content' => 'this is contetn',
        'image' => null,
    ]);

    $response->assertJsonStructure(['status', 'message']);

    // Add assertions based on your application's logic
    $this->assertDatabaseHas('posts', ['title' => 'my title', 'author' => 'the author']);
});


it('can save a book with image', function () {

    // Assuming you have Livewire component and routes properly set up
    // $this->actingAs(User::factory()->create());
    $response = $this->post('/save-book', [
        'title' => 'my title3',
        'author' => 'the author',
        'content' => 'this is contetn',
        'image' => UploadedFile::fake()->image('test-image.jpg'),
    ]);

    $response->assertRedirect('/books');

    $this->assertDatabaseHas('posts', ['title' => 'my title3', 'author' => 'the author']);

    $post = Post::where('title', 'my title3')->first();

    // Assert that the attachment file exists
    $this->assertFileExists(public_path('storage/' . $post->image));
});


it('validates required fields all without image', function () {
    $this->post('/save-book')
        ->assertSessionHasErrors(['title', 'author', 'content']);
});


it('validates required fields with invalid image', function () {
    $this->post('/save-book', ['image' => 'sadsad'])
        ->assertSessionHasErrors(['title', 'author', 'content', 'image']);
});


it('validates required fields with valid image', function () {
    $this->post('/save-book', ['image' => UploadedFile::fake()->image('test-image.jpg'),])
        ->assertSessionHasErrors(['title', 'author', 'content']);
});



it('validates unique title', function () {
    $response = $this->post('/save-book', [
        'title' => 'my title',
        'author' => 'the author',
        'content' => 'this is contetn',
        'image' => null,
    ]);

    $response2 = $this->post('/save-book', [
        'title' => 'my title',
        'author' => 'the author',
        'content' => 'this is contetn',
        'image' => null,
    ])
    ->assertSessionHasErrors(['title']);

});

echo "api // HomeController ended";
echo "\n\n ===================================";
