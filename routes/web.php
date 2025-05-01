<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;
use App\Http\Controllers\UserController;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    // return Carbon::parse('2023-11-01')->addDays(3)->format('Y-m-d');
    // return Carbon::parse('2023-11-01')->addDays(120)->format('Y-m-d');
    return view('welcome');
})->name('home');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('feed');
Route::get('/friends', [HomeController::class, 'friends'])->name('friends');

Route::resource('books', PostController::class);
Route::post('save-book', [HomeController::class, 'saveBook'])->name('save-book');

Route::match(['get', 'post'], 'compare-database', function () {
    return App\Services\Database\CompareChainer::index();
});

Route::post('db-compare-apply', function () {
    return App\Services\Database\CompareChainer::applyUpdates();
})->name('db-compare-apply');

Route::get('bills/create', [BillController::class, 'create'])->name('bills.create');
Route::post('bills', [BillController::class, 'store'])->name('bills.store');

Route::get('generator_builder', '\AlbadrSystems\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

Route::get('field_template', '\AlbadrSystems\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

Route::get('relation_field_template', '\AlbadrSystems\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

Route::post('generator_builder/generate', '\AlbadrSystems\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

Route::post('generator_builder/rollback', '\AlbadrSystems\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

Route::post(
    'generator_builder/generate-from-file',
    '\AlbadrSystems\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');

Route::resource('users', UserController::class)->middleware('auth');

Route::resource('regions', App\Http\Controllers\RegionController::class);

include_once app_path('Services/Procedures/routes.php');
