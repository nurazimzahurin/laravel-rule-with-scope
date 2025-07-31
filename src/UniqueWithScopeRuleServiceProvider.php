<?php

namespace Nurazimzahurin\LaravelRuleWithScope;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class UniqueWithScopeRuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('unique_with_scope', function ($attribute, $value, $parameters, $validator) {
            list($modelClass, $column) = $parameters;
            $exceptId = $parameters[2] ?? null;
            $idColumn = $parameters[3] ?? 'id';

            $query = (new $modelClass)->newQuery();
            $query->where($column, $value);

            if ($exceptId !== null) {
                $query->where($idColumn, '<>', $exceptId);
            }

            return !$query->exists();
        });

        Validator::replacer('unique_with_scope', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, $message);
        });
    }

    public function register()
    {
        //
    }
}
