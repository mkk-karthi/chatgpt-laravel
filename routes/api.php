<?php

use App\Http\Controllers\ChatGroupController;
use App\Http\Controllers\ChatsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/chat_groups', [ChatGroupController::class, "list"]);
Route::post('/chat_group/create', [ChatGroupController::class, "create"]);
Route::post('/chat_group/update/{id}', [ChatGroupController::class, "update"]);
Route::get('/chat_group/delete/{id}', [ChatGroupController::class, "delete"]);

Route::get('/chats/{id}', [ChatsController::class, "list"]);
Route::post('/stream_chat', [ChatsController::class, "stream_chat"]);
