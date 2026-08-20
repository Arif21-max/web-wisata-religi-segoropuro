<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        if (App::runningInConsole()) {
            return;
        }

        if (App::environment('local')) {
            $this->ensureEnvConfigured();
            $this->ensureAppKeyExists();
            $this->ensureDatabaseExists();
        }
    }

    /**
     * Fix .env configuration if needed.
     */
    private function ensureEnvConfigured(): void
    {
        $envPath = base_path('.env');
        if (!File::exists($envPath)) {
            return;
        }

        $envContent = File::get($envPath);
        $changed = false;

        // Fix empty DB_DATABASE
        if (preg_match('/^DB_DATABASE=\s*$/m', $envContent)) {
            $dbPath = str_replace('\\', '/', database_path('database.sqlite'));
            $envContent = preg_replace('/^DB_DATABASE=\s*$/m', "DB_DATABASE={$dbPath}", $envContent);
            $changed = true;
        }

        if ($changed) {
            File::put($envPath, $envContent);
            // Reload env
            if (method_exists($this->app['env'], 'addLoader')) {
                $this->app['env']->addLoader();
            }
        }
    }

    /**
     * Auto-generate APP_KEY if not set.
     */
    private function ensureAppKeyExists(): void
    {
        if (config('app.key')) {
            return;
        }

        $key = 'base64:' . base64_encode(random_bytes(32));
        config(['app.key' => $key]);

        $envPath = base_path('.env');
        if (File::exists($envPath)) {
            $envContent = File::get($envPath);
            if (preg_match('/^APP_KEY=/m', $envContent)) {
                $envContent = preg_replace('/^APP_KEY=.*/m', "APP_KEY={$key}", $envContent);
            } else {
                $envContent .= "\nAPP_KEY={$key}\n";
            }
            File::put($envPath, $envContent);
        }
    }

    /**
     * Auto-create database file and run migrations if needed.
     */
    private function ensureDatabaseExists(): void
    {
        $dbPath = database_path('database.sqlite');

        // Create database file if it doesn't exist
        if (!File::exists($dbPath)) {
            File::put($dbPath, '');
        }

        // Check if migrations have run
        try {
            $hasUsersTable = \Illuminate\Support\Facades\Schema::hasTable('users');
            if (!$hasUsersTable) {
                Artisan::call('migrate', ['--force' => true]);
                Artisan::call('db:seed', ['--force' => true]);
            }
        } catch (\Exception $e) {
            // If migration fails, try fresh
            try {
                Artisan::call('migrate:fresh', ['--force' => true]);
                Artisan::call('db:seed', ['--force' => true]);
            } catch (\Exception $e2) {
                // Silently fail - user needs to run manually
            }
        }
    }
}
