<?php

namespace App\Providers;

use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\ServiceProvider;

class FirestoreServiceProvider extends ServiceProvider
{
/**
* Register services.
*
* @return void
*/
public function register()
{
$this->app->singleton(FirestoreClient::class, function ($app) {
return new FirestoreClient([
'keyFilePath' => base_path(env('FIREBASE_CREDENTIALS')),
]);
});
}

/**
* Bootstrap services.
*
* @return void
*/
public function boot()
{
//
}
}
