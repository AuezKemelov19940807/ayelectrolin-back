<?php

namespace App\Providers;

use App\Storage\GoogleCloudAdapter;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\Filesystem;

class GoogleCloudStorageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Storage::extend('gcs', function ($app, $config) {

        //     $client = new StorageClient([
        //         'projectId' => $config['project_id'],
        //         'keyFilePath' => $config['key_file'],
        //     ]);

        //     $adapter = new GoogleCloudAdapter(
        //         $client,
        //         $config['bucket'],
        //         $config['path_prefix'] ?? '',
        //         $config['api_url'] ?? 'https://storage.googleapis.com'
        //     );

        //     $filesystem = new Filesystem($adapter);

        //     // ВАЖНО — вернуть FilesystemAdapter, а не Flysystem
        //     return new FilesystemAdapter($filesystem, $adapter, $config);
        // });
    }
}
