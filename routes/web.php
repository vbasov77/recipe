<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ImgController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MessageController;
use \Illuminate\Support\Facades\Auth;
use \App\Http\Controllers\SessionController;

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

Route::get('/', [FrontController::class, 'front'])->name("front");
Route::get('/home', [FrontController::class, 'front'])->name("front");

Route::get('/recipe{id}', [RecipeController::class, 'show'])->name("recipe");
Route::get('/edit-recipe{id}', [RecipeController::class, 'edit'])->name("edit.recipe")->middleware('auth');
Route::get('/create-recipe', [RecipeController::class, 'create'])->name("create.recipe")->middleware('auth');
Route::post('/store-recipe', [RecipeController::class, 'store'])->name("store.recipe")->middleware('auth');
Route::post('/update-recipe', [RecipeController::class, 'update'])->name("update.recipe")->middleware('auth');
Route::any('/delete-recipe/id{id}', [RecipeController::class, 'destroy'])->name("delete.recipe")->middleware('auth');

Route::delete('/delete-img/{id}/{file}', [ImgController::class, 'deleteImg'])->name("delete.img")->middleware('auth');

Route::post('/save_comment', [CommentController::class, 'saveComment'])->name('save.comment');

Route::post('/search', [SearchController::class, 'search'])->name('search');
Route::delete('/delete_session', [SearchController::class, 'deleteSession'])->name("delete.session");
Route::delete('/delete-comment', [CommentController::class, 'destroy'])->name("comment.delete");

Route::get('/messages', 'MessageController@myMessages')->name('my.messages')->middleware('auth');
Route::get('/message{to_user_id}', [MessageController::class, 'view'])->name('view.messages')->middleware('auth');
Route::post('/add_message', [MessageController::class, 'store'])->name('add.message')->middleware('auth');
Route::get('/delete_message', [MessageController::class, 'destroy'])->name('delete.message')->middleware('auth');
Route::get('/delete_chat', 'MessageController@deleteChat')->name('delete.chat')->middleware('auth');
Route::post('/check_message', 'MessageController@checkNewMsg')->name('check.message')->middleware('auth');
Route::post('/notified', 'MessageController@notified')->name('notified.message')->middleware('auth');

Route::post('/add_session', [SessionController::class, 'addSession'])->name('add.session')->middleware('auth');


Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Кэш очищен.";
})->name('clear');

Route::get('/ws', function () {
    Artisan::call('ws:run');
    return "socket запущен...";
});
Auth::routes();

