<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
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
        Response::macro('withJson', function (array $data) {
            $defaults = [
                'message' => __('auth.success'),
                'status'  => 200,
                'data'    => [],
            ];

            $output = collect($defaults)->merge($data)->only(array_keys($defaults));

            return Response::json($output, (int) $output['status']);
        });
    }
}
