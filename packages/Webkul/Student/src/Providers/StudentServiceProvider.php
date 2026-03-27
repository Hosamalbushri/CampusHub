<?php

namespace Webkul\Student\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Webkul\Student\Services\Contracts\UniversityStudentApiContract;
use Webkul\Student\Services\FakeUniversityStudentApiClient;
use Webkul\Student\Services\UniversityStudentApiClient;

class StudentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerConfig();

        $this->app->singleton(UniversityStudentApiContract::class, function ($app) {
            if (config('student.university.fake', false)) {
                return new FakeUniversityStudentApiClient;
            }

            return new UniversityStudentApiClient;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        RateLimiter::for('student-login', function (Request $request) {
            return Limit::perMinute(5)->by(
                sha1($request->ip().'|'.(string) $request->input('university_card_number'))
            );
        });

        Route::middleware(['web', 'admin_locale', PreventRequestsDuringMaintenance::class])
            ->group(__DIR__.'/../Routes/web.php');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'student');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'student');
    }

    /**
     * Register package config.
     */
    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/student.php',
            'student'
        );
    }
}
