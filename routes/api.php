<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\UrlShortener;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('short-url', function (Request $request) {
        $response = UrlShortener::generateShortUrl($request->input('url'));
        return $response;
    });
    Route::get('latest-url', function (Request $request) {
        $response = UrlShortener::paginate(10);
        return $response;
    });
    Route::delete('short-url/{id}', function ($id) {
        $url = UrlShortener::find($id);

        $response = $url->delete();
        return $response;
    });
});