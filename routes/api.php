<?php

use App\Http\Controllers\Api\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('login', function () {

    $request = request();

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Authentication passed...
        $user = Auth::user();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    return response()->json(['error' => 'Invalid credentials'], 401);
});

Route::middleware('auth:sanctum')
    ->namespace('Api')
    ->prefix('v1')
    ->group(function () {

        Route::get('/user', function (Request $request) {
            return response()->json([
                'status' => true,
                'data' => $request->user()
            ]);
        });

        Route::post('save-book', [HomeController::class, 'saveBook'])->name('api-save-book');
    });
