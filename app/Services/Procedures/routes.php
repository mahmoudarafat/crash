<?php

use App\Services\Procedures\MainController;

Route::group(['prefix' => 'procedures'], function () {
  Route::get('/', function () {
    return MainController::index();
  });

  Route::get('create', function () {
    return MainController::create();
  })->name('procedures.create');

  Route::post('/save', function () {
    return MainController::store();
  })->name('procedures.save');

  Route::get('edit/{id}', function ($id) {
    return MainController::edit($id);
  })->name('procedures.edit');

  Route::post('/update', function () {
    return MainController::update();
  })->name('procedures.update');
});
