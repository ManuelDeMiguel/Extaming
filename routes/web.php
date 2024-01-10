<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}/comments', [App\Http\Controllers\CommentController::class, 'show'])->name('comments.show');

Route::get('/profile/{user}', [App\Http\Controllers\UserController::class, 'otherProfile'])->name('other-profile');
// Rutas de autenticación
Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Rutas de Perfil de Usuario
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('profile.update');


    //Rutas de amistad
    Route::post('/profile/{user}/send-friend-request', [App\Http\Controllers\UserController::class, 'sendFriendRequest'])->name('send.friend.request');
    Route::delete('/profile/{user}/cancel-friend-request', [App\Http\Controllers\UserController::class, 'cancelFriendRequest'])->name('cancel.friend.request');
    Route::post('/profile/{user}/accept-friend-request', [App\Http\Controllers\UserController::class, 'acceptFriendRequest'])->name('accept.friend.request');
    Route::post('/profile/{user}/reject-friend-request', [App\Http\Controllers\UserController::class, 'rejectFriendRequest'])->name('reject.friend.request');
    Route::post('/profile/{user}/remove-friend', [App\Http\Controllers\UserController::class, 'removeFriend'])->name('remove.friend');

    // Rutas de Publicaciones
    Route::post('/posts', [App\Http\Controllers\PostController::class, 'create'])->name('posts.create');

    // Rutas de "Me gusta"
    Route::get('/posts/{post}/like', [App\Http\Controllers\LikeController::class, 'toggleLike'])->name('posts.like');

    // Rutas de Comentarios
    Route::post('/posts/{post}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');

    // Rutas de Mensajes Directos
    Route::get('/direct-messages', [App\Http\Controllers\ConversationController::class, 'index'])->name('direct-messages.index');
    Route::get('/direct-messages/{conversation}/{user}', [App\Http\Controllers\DirectMessageController::class, 'show'])->name('direct-messages.show');
    Route::post('/direct-messages/{conversation}/{user}/{message}', [App\Http\Controllers\DirectMessageController::class, 'store'])->name('direct-messages.store');
    Route::post('/conversations/{user}', [App\Http\Controllers\ConversationController::class, 'store'])->name('conversation.store');

    // Rutas de Chats Grupales
    Route::get('/group-chats', [App\Http\Controllers\PostController::class, 'index'])->name('group-chats.index');
    Route::get('/group-chats/create', 'GroupChatController@create')->name('group-chats.create');
    Route::post('/group-chats', 'GroupChatController@store')->name('group-chats.store');
    Route::get('/group-chats/{groupChat}', 'GroupChatController@show')->name('group-chats.show');
    Route::post('/group-chats/{groupChat}/add-user', 'GroupChatController@addUser')->name('group-chats.add-user');
    Route::post('/group-chats/{groupChat}/remove-user', 'GroupChatController@removeUser')->name('group-chats.remove-user');
    Route::delete('/group-chats/{groupChat}', 'GroupChatController@destroy')->name('group-chats.destroy');
});


