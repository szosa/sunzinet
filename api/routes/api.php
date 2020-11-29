<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'UserController@register');
Route::post('/login', 'AuthController@login');
Route::post('/upload-file', 'FileController@uploadFile');
Route::put('/change-file-name/{fileId}', 'FileController@changeFileName');
Route::delete('/delete-file/{fileId}', 'FileController@deleteFile');
Route::get('/download/{fileId}', 'FileController@download');
Route::get('/get-user-files', 'FileController@getUserFiles');
