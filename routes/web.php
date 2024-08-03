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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fresh', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh --seed');

    dd("migrate:fresh --seed");
});
Route:: get('/insert', function() {
$stuRef = app('firebase.firestore')->database()->collection ('Students') ->newDocument();
$stuRef->set([

'firstname' => 'Seven',
'lastname' => 'Stac',
    'age' => '19']);
});
// routes/web.php

// routes/web.php

Route::get('/test-env', function () {
    return response()->json([
        'firebase_credentials' => env('FIREBASE_CREDENTIALS')
    ]);
});

Route::get('/check-file', function () {
    $path = env('FIREBASE_CREDENTIALS');
    return response()->json([
        'exists' => file_exists($path),
        'readable' => is_readable($path),
        'path' => $path,
    ]);
});

