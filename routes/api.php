<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

use function App\Http\Controllers\updateRole;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('role', [RoleController::class, 'createRole']);
Route::get('role', [RoleController::class, 'getRole']);
Route::get('role/{id}', [RoleController::class, 'getRole']);
Route::put('role/{id}', [RoleController::class, 'updateRole']);
Route::delete('role/{id}', [RoleController::class, 'deleteRole']);

//Added the below with tr
Route::get('/getAllRoles', [RoleController::class, 'index']);
Route::get('/createRole',[RoleController::class, 'createRole' ]);
Route::get('getRole/{$id}',[RoleController::class, 'getRole']);
Route::put('updateRole',[RoleController::class, 'updateRole']);
Route::delete('deleteRole', [RoleController::class, 'deleteRole']);





