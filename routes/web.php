<?php

use Illuminate\Support\Facades\Route;
use App\Models\UrlShortener;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/{url}', function ($url) {
    $original = UrlShortener::getOriginalUrlFromKey($url);
    return redirect($original);
});
