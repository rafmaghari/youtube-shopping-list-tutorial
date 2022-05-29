<?php

use App\Http\Controllers\ShoppingListController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//let's add that endpoint here
Route::get('/shopping-list-data', [ShoppingListController::class, 'list']);
Route::resource('/shopping-list', ShoppingListController::class);
