<?php

namespace Catanchin\NovaNotesField;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use OptimistDigital\NovaTranslationsLoader\LoadsNovaTranslations;

class FieldServiceProvider extends ServiceProvider
{
    use LoadsNovaTranslations;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Config
        $this->publishes([
            __DIR__ . '/../config/nova-notes-field.php' => config_path('nova-notes-field.php'),
        ], 'config');

        // Load translations
        $this->loadTranslations(__DIR__ . '/../resources/lang', 'nova-notes-field', true);

        // Serve assets
        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-notes-field', __DIR__ . '/../dist/js/field.js');
        });

        // Load routes
        $this->app->booted(function () {
            $this->routes();
        });
    }

    protected function routes()
    {
        if ($this->app->routesAreCached()) return;

        Route::middleware(['nova'])
            ->prefix('nova-vendor/nova-notes')
            ->namespace('\OptimistDigital\NovaNotesField\Http\Controllers')
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
