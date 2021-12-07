<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

Builder::macro('whereLike', function ($columns, string $value, $concat = false) {
    $this->where(function (Builder $query) use ($columns, $value, $concat) {
        foreach (Arr::wrap($columns) as $column) {
            $query->when(
                Str::contains($column, '.'),
                function (Builder $query) use ($column, $value) {
                    $parts = explode('.', $column);
                    $relationColumn = array_pop($parts);
                    $relationName = implode('.', $parts);

                    return $query->orWhereHas(
                        $relationName,
                        function (Builder $query) use ($relationColumn, $value) {
                            $query->where($relationColumn, 'LIKE', "%{$value}%");
                        }
                    );
                },
                function (Builder $query) use ($column, $value, $concat) {
                    return $concat ?
                        $query->orWhereRaw("CONCAT(users.name, ' ', users.last_name) like '%{$value}%'")
                            ->orWhere($column, 'LIKE', "%{$value}%") :
                        $query->orWhere($column, 'LIKE', "%{$value}%");
                }
            );
        }
    });

    return $this;
});
