<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    NewfeedController,
    NotificationController,
    FriendController,
    ChatController
};
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
Broadcast::routes(['middleware' => ['jwt.verify']]);

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/signup', [AuthController::class, 'signup']);

Route::middleware('jwt.verify')->prefix('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/user', [AuthController::class, 'user']);

});
Route::middleware('jwt.verify')->group(function () {
    Route::prefix('newfeed')->middleware('jwt.verify')->group(function (){
        Route::post('/', [NewfeedController::class, 'index']);
        Route::get('{newfeedID}/disabled-comment', [NewfeedController::class, 'disabledComment']);
        Route::get('{newfeedID}/react-post', [NewfeedController::class, 'reactPost']);
        Route::get('{newfeedID}/show', [NewfeedController::class, 'show']);
        Route::get('{newfeedID}/comment', [NewfeedController::class, 'comment']);
        Route::post('{newfeedID}/share', [NewfeedController::class, 'share']);
        Route::post('{newfeedID}/save-comment', [NewfeedController::class, 'saveComment']);
        Route::post('{commentID}/remove-comment', [NewfeedController::class, 'removeComment']);
        Route::post('upload', [NewfeedController::class, 'uploadPost']);
        Route::post('{newfeedID}/status', [NewfeedController::class, 'changeStatus']);
        Route::get('comment/{commentID}/reply', [NewfeedController::class, 'reply']);
        Route::get('{newfeedID}/destroy', [NewfeedController::class, 'destroy']);
        Route::get('{newfeedID}/update', [NewfeedController::class, 'update']);
        Route::get('{newfeedID}/react', [NewfeedController::class, 'reactList']);
    });
    Route::prefix('u')->middleware('jwt.verify')->group(function (){
        Route::get('/', [FriendController::class, 'getFriends']);
        Route::get('/{userID}', [FriendController::class, 'getFriend']);
        Route::get('/{userID}/newfeed', [FriendController::class, 'getNewfeed']);
        Route::post('request/appect', [FriendController::class, 'acpectFriends']);
        Route::post('request/decline', [FriendController::class, 'declineFriends']);
        Route::post('request/send', [FriendController::class, 'friendRequest']);
        Route::post('unfriend', [FriendController::class, 'unfriend']);
    });
    Route::prefix('notification')->group(function (){
        Route::post('/read-all', [NotificationController::class, 'readAll']);
        Route::post('/get-list', [NotificationController::class, 'list']);
    });
    Route::prefix('chat')->group(function (){
        Route::get('/{userID}', [ChatController::class, 'loadChat']);
        Route::post('/{userID}/send', [ChatController::class, 'sendChat']);
    });
});
