<?php

namespace NamTrail\ActivityLog\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

class ActivityLogServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/activity-log.php', 'activity-log'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       
        $this->publishes([
            __DIR__ . '/../config/activity-log.php' => config_path('activity-log.php'),
        ], 'activity-log-config');

       
        $this->publishes([
            __DIR__ . '/../database/migrations/create_activity_logs_table.php.stub' => $this->getMigrationFileName(),
        ], 'activity-log-migrations');
    }

    /**
     * Returns migration file name with timestamp.
     *
     * @return string
     */
    protected function getMigrationFileName()
    {
        $timestamp = date('Y_m_d_His');
        $filesystem = new Filesystem();

        return Collection::make(app()->databasePath('migrations') . DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem) {
                return $filesystem->glob($path . '*_create_activity_logs_table.php');
            })
            ->push(app()->databasePath('migrations/' . $timestamp . '_create_activity_logs_table.php'))
            ->first();
    }
}