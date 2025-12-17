<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->ensureStorageLinkExists();
    }

    private function ensureStorageLinkExists(): void
    {
        $storageLink = public_path('storage');
        $storageTarget = storage_path('app/public');
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

        if (!file_exists($storageLink)) {
            // Create new link
            if ($isWindows) {
                exec("mklink /J \"" . str_replace('/', '\\', $storageLink) . "\" \"" . str_replace('/', '\\', $storageTarget) . "\"");
            } else {
                symlink($storageTarget, $storageLink);
            }
        } elseif (!$isWindows && !is_link($storageLink)) {
            // Unix/Linux: remove and recreate if not a symlink
            if (is_dir($storageLink)) {
                rmdir($storageLink);
            } else {
                unlink($storageLink);
            }
            symlink($storageTarget, $storageLink);
        } elseif ($isWindows && is_dir($storageLink) && !is_link($storageLink)) {
            // Windows: remove directory and create junction
            rmdir($storageLink);
            exec("mklink /J \"" . str_replace('/', '\\', $storageLink) . "\" \"" . str_replace('/', '\\', $storageTarget) . "\"");
        }
    }
}
