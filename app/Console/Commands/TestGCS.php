<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestGcs extends Command
{
    protected $signature = 'test:gcs {--path=test/gcs-check.txt}';
    protected $description = 'Check Google Cloud Storage connection: env, key file, list, put, exists.';

    public function handle()
    {
        $this->info('=== Test GCS connection ===');

        $projectId =  'intense-context-471105-t9';
        $bucket = 'ayelectrolin-storage';
        $keyFile = 'D:/fullStack/laravel+vue+filament/aiElectroLin/back/ayelectrolin/storage/app/credentials/google-cloud.json';

        $this->line("Project ID: " . ($projectId ?: '<not set>'));
        $this->line("Bucket: " . ($bucket ?: '<not set>'));
        $this->line("Key file: " . ($keyFile ?: '<not set>'));

        // Проверка наличия файла ключа на диске
        if (!$keyFile || !file_exists($keyFile)) {
            $this->error("Key file not found at: {$keyFile}");
            $this->comment("Проверь путь в .env (GOOGLE_CLOUD_KEY_FILE) и права доступа к файлу.");
            return 1;
        } else {
            $this->info("Key file exists.");
        }

        // Попытка получить диск
        try {
            $disk = Storage::disk('gcs');
        } catch (\Throwable $e) {
            $this->error("Cannot initialize Storage::disk('gcs'): " . $e->getMessage());
            return 1;
        }

        // Попытка листинга (корень)
        $this->info("Attempting to list root files (first 10 entries)...");
        try {
            $files = $disk->files('');
            $this->line("Files count returned: " . (is_countable($files) ? count($files) : 'n/a'));
            $this->line(json_encode(array_slice($files ?: [], 0, 10), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        } catch (\Throwable $e) {
            $this->error("List files failed: " . $e->getMessage());
        }

        // Попытка записать тестовый файл
        $path = $this->option('path') ?: 'test/gcs-check.txt';
        $this->info("Trying to write to: {$path}");

        try {
            $ok = $disk->put($path, "GCS test at " . now()->toDateTimeString());
        } catch (\Throwable $e) {
            $this->error("Put failed with exception: " . $e->getMessage());
            $ok = false;
        }

        $this->line("Put returned: " . ($ok ? 'true' : 'false'));

        // Проверка exists
        try {
            $exists = $disk->exists($path);
            $this->line("Exists check: " . ($exists ? 'true' : 'false'));
        } catch (\Throwable $e) {
            $this->error("Exists check failed: " . $e->getMessage());
            $exists = false;
        }

        // Попытка удалить тестовый файл (чтобы не мусорить)
        $this->info("Attempting to delete test file (cleanup)...");
        try {
            if ($disk->exists($path)) {
                $disk->delete($path);
                $this->info("Deleted: {$path}");
            } else {
                $this->line("No file to delete.");
            }
        } catch (\Throwable $e) {
            $this->error("Delete failed: " . $e->getMessage());
        }

        $this->info('=== Done ===');

        return $ok ? 0 : 1;
    }
}
