<?php

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

Route::post('/push/subscribe', function (\Illuminate\Http\Request $request) {
    \App\User::first()->updatePushSubscription(
        $request->input('endpoint'),
        $request->input('key'),
        $request->input('secret')
    );
});
