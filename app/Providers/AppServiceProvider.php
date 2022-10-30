<?php

namespace App\Providers;

use Flugg\Responder\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        DB::listen(function (QueryExecuted $sql) {
            $statement = Str::replaceArray('?', array_map(fn ($v) => is_numeric($v) ? "$v" : "'$v'", $sql->bindings), $sql->sql);
            Log::debug("$statement --- {$sql->time}ms");
        });

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
