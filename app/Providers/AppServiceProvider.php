<?php

namespace App\Providers;

use Flugg\Responder\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $macro = function (int $limit = null, string $cursor = null) {
            $limit ??= (int) request('limit', 15);
            $cursor ??= request('cursor');

            $paginationMethod = request()->has('cursor') ? 'cursorPaginate' : 'paginate';

            $resolveCursor = function () use ($paginationMethod, $limit, $cursor) {
                if (function_exists('responder')) {
                    $data = $this->{$paginationMethod}($limit);
                    return new CursorPaginator(
                        $data->items(),
                        optional($data->cursor())->encode(),
                        optional($data->previousCursor())->encode(),
                        optional($data->nextCursor())->encode()
                    );
                } else {
                    return $this->{$paginationMethod}($limit, ['*'], 'cursor', $cursor);
                }
            };

            return $paginationMethod === 'cursorPaginate'
                ? $resolveCursor()
                : $this->{$paginationMethod}($limit);
        };

        EloquentBuilder::macro('smartPaginate', $macro);
        QueryBuilder::macro('smartPaginate', $macro);
    }
}
