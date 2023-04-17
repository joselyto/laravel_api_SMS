<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SmsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/contacts', [SmsController::class, 'contacts']);
Route::post('/createcontatct', [SmsController::class, 'createContatct']);



Route::get('/conversation_detail/{id}', [SmsController::class, 'conversation_detail']);


Route::get('/liste_conversation/{id}', [SmsController::class, 'maliste_conversation']);

Route::post('/envoyermessage/{id}', [SmsController::class, 'envoyerMessage']);


Route::get('/maliste_message/{id}', [SmsController::class, 'maliste_message']);

