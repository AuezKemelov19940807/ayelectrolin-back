<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Google\Cloud\Storage\StorageClient;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use League\Flysystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter as LaravelFilesystemAdapter;
use Illuminate\Contracts\Foundation\Application;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }


    public function boot(): void
{
    if (app()->environment('production')) {
        \Illuminate\Support\Facades\URL::forceScheme('https');
    }

    Storage::extend('gcs', function ($app, $config) {
        $client = new StorageClient([
            'projectId' => $config['project_id'],
            'keyFilePath' => $config['key_file'],
        ]);

        $bucket = $client->bucket($config['bucket']);

        $adapter = new GoogleCloudStorageAdapter(
            $bucket,
            $config['path_prefix'] ?? '',
            null
        );

        return new LaravelFilesystemAdapter(
            new Filesystem($adapter),
            $adapter,
            $config
        );
    });

    // === ВАЖНО === добавляем поддержку URL для Filament

    Storage::disk('gcs')->macro('url', function ($path) {
        $bucket = env('GOOGLE_CLOUD_STORAGE_BUCKET');
        return "https://storage.googleapis.com/{$bucket}/" . ltrim($path, '/');
    });

    Storage::disk('gcs')->macro('temporaryUrl', function ($path, $expiration = null, $options = []) {
        $bucket = env('GOOGLE_CLOUD_STORAGE_BUCKET');
        return "https://storage.googleapis.com/{$bucket}/" . ltrim($path, '/');
    });
}

    // public function boot(): void
    // {
    //     // force https in production
    //     if (app()->environment('production')) {
    //         \Illuminate\Support\Facades\URL::forceScheme('https');
    //     }

    //     // Register GCS driver
    //     Storage::extend('gcs', function (Application $app, array $config) {
    //         $client = new StorageClient([
    //             'projectId' => $config['project_id'] ?? env('GOOGLE_CLOUD_PROJECT_ID'),
    //             'keyFilePath' => $config['key_file'] ?? env('GOOGLE_CLOUD_KEY_FILE'),
    //         ]);

    //         $bucket = $client->bucket($config['bucket'] ?? env('GOOGLE_CLOUD_STORAGE_BUCKET'));

    //         $adapter = new GoogleCloudStorageAdapter(
    //             $bucket,
    //             $config['path_prefix'] ?? '',
    //             null // без VisibilityConverter, используем опции predefinedAcl
    //         );

    //         return new LaravelFilesystemAdapter(
    //             new Filesystem($adapter),
    //             $adapter,
    //             $config
    //         );
    //     });

    //     //     Storage::disk('gcs')->macro('url', function ($path) {
    //     //       $bucket = env('GOOGLE_CLOUD_STORAGE_BUCKET');
    //     //     return "https://storage.googleapis.com/{$bucket}/" . ltrim($path, '/');
    //     //    });



    //     //    Storage::disk('gcs')->macro('temporaryUrl', function ($path, $expiration = null, $options = []) {
    //     //         $bucket = env('GOOGLE_CLOUD_STORAGE_BUCKET');

    //     //           return "https://storage.googleapis.com/{$bucket}/" . ltrim($path, '/');
    //     //      });

    // }
}
