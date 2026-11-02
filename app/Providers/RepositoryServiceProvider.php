<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array<class-string, class-string>
     */
    public array $bindings = [
        // Example:
        // \App\Repositories\Contracts\CourseRepositoryInterface::class => \App\Repositories\Eloquent\CourseRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind repositories dynamically if needed
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
