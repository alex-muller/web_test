<?php

namespace App\Providers;

use App\Infrastructure\Interfaces\IRemoteStorageClient;
use App\Infrastructure\RemoteStorageClient;
use App\Modules\Interfaces\IRemoteStorageService;
use App\Modules\RemoteStorage\RemoteStorageService;
use Aws\Credentials\Credentials;
use Aws\S3\S3Client;
use Aws\S3\S3ClientInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IRemoteStorageClient::class, RemoteStorageClient::class);

        $this->app->when(RemoteStorageClient::class)
            ->needs(S3ClientInterface::class)
            ->give(function() {
                $s3Client = new S3Client([
                    'version'     => 'latest',
                    'region'      => config('remotestorage.s3ClientRegion'),
                    'credentials' => new Credentials(config('remotestorage.s3ClientKey'),config('remotestorage.s3ClintSecret')),
                ]);

                return $s3Client;
            });

        $this->app->when(RemoteStorageClient::class)
          ->needs('$bucketName')
          ->give(config('remotestorage.s3ClientBucket'));

        $this->app->when(RemoteStorageClient::class)
            ->needs(Filesystem::class)
            ->give(function() {
                return Storage::disk('local');
            });


        /*
        $this->app->bind(IRemoteStorageClient::class, function($app) {
           return new RemoteStorageClient(
               $app->make(S3ClientInterface::class),
               config('remotestorage.s3ClientBucket'),
               Storage::disk('local')
           );
        });
        */

        $this->app->bind(IRemoteStorageService::class,RemoteStorageService::class);
    }
}
