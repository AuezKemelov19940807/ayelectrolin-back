<?php

namespace App\Providers;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use Illuminate\Filesystem\FilesystemAdapter as LaravelFilesystemAdapter;

class GCSServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Storage::extend('gcs', function ($app, $config) {
            $client = new StorageClient([
                'projectId' => 'intense-context-471105-t9',
                'keyFilePath' => 'storage/app/google-cloud.json',
            ]);

            $bucket = $client->bucket('ayelectrolin-storage');

            // Flysystem 3 adapter
            $adapter = new GoogleCloudStorageAdapter($bucket);

            // Flysystem 3 FilesystemOperator
            $filesystem = new Filesystem($adapter);

            // Laravel adapter
            return new LaravelFilesystemAdapter($filesystem, $adapter, $config);
        });
    }
}
