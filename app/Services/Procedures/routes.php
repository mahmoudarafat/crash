<?php

use App\Services\Procedures\ProcedureController;

Route::group(['prefix' => 'procedures'], function () {
  Route::get('/', function () {
    return ProcedureController::index();
  })->name('procedures.index');

  Route::get('create', function () {
    return ProcedureController::create();
  })->name('procedures.create');

  Route::post('/save', function () {
    return ProcedureController::store();
  })->name('procedures.save');

  Route::get('edit/{id}', function ($id) {
    return ProcedureController::edit($id);
  })->name('procedures.edit');

  Route::post('/update', function () {
    return ProcedureController::update();
  })->name('procedures.update');
});
