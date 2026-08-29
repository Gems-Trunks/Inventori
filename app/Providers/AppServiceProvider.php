<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
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
        //
        Builder::macro('search', function (array $columns, $term) {
            return $this->where(function ($query) use ($term, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', "%{$term}%");
                }
            });
        });
    }
}
