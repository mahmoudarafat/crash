<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Post::get()
        ], 201);
        // return view('home');
    }

    public function friends()
    {
        return view('friends');
    }


    public function saveBook(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|unique:posts,title|string|max:255',
                'author' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|max:10240', // 10 MB limit for image size
            ]);

            $data = $request->only(['title', 'author', 'content']);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('uploads', 'public');
                $data['image_path'] = $imagePath;
            }

            Post::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Book created successfully.'
            ]);
            
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'error' => $e->validator->errors()
            ], 422);
        }
    }
}
