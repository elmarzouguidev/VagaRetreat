<?php

namespace App\Providers;

use App\Enums\Roles\RolesEnums;
use Carbon\CarbonImmutable;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        $this->addBooleanFields();
        $this->configureCommands();
       // $this->configureDates();
        $this->configureModels();
        $this->configurePasswordValidation();
        $this->configureFakePictureGenerator();
        $this->configureRateLimiter();
        $this->configureGate();
    }

    private function addBooleanFields(): void
    {
        Blueprint::macro('booleanFields', function () {
            $this->boolean('is_active')->default(true);
            $this->boolean('is_valid')->default(true);
        });
    }
    /**
     * Configure the application's commands.
     */
    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction()
        );
    }

    /**
     * Configure the dates.
     */
    private function configureDates(): void
    {
        Date::use(CarbonImmutable::class);
       // Carbon::setLocale('fr_FR');
    }

    /**
     * Configure the models.
     */
    private function configureModels(): void
    {
        Model::shouldBeStrict(! $this->app->isProduction());
        Model::unguard();
    }

    /**
     * Configure the password validation rules.
     */
    private function configurePasswordValidation(): void
    {
        Password::defaults(fn() => $this->app->isProduction() ? Password::min(8)->uncompromised() : null);
    }

    private function configureFakePictureGenerator(): void
    {
        Factory::macro('getFakePictureUrl', function (int $width, int $height): string {
            return sprintf(
                'https://picsum.photos/%d/%d',
                $width,
                $height
            );
        });
    }


    /**
     * Configure the RateLimiter.
     */
    private function configureRateLimiter(): void
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(8)->by($request->user()?->id ?: $request->ip())
                ->response(function ($request, array $headers) {
                    return response()->json(['message' => 'Request limit reached. You are temporarily blocked due to excessive requests. Try again later ...'], 429, $headers);
                });
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()?->id ?: $request->ip())
                ->response(function ($request, array $headers) {
                    return response()->json(['message' => 'Request limit reached. You are temporarily blocked due to excessive requests. Try again later ...'], 429, $headers);
                });
        });

        // Stripe webhook rate limiting
        RateLimiter::for('stripe-webhooks', function (Request $request) {
            return Limit::perMinute(100)->by($request->ip());
        });
    }

    private function configureGate(): void
    {

        Gate::before(function ($user, $ability) {
            return $user->hasRole(RolesEnums::SUPERADMIN) ? true : null;
        });
    }

    private function defineObservers(): void {}
}
