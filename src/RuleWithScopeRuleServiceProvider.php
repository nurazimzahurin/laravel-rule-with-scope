<?php

namespace Nurazimzahurin\LaravelRuleWithScope;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use NurazimZahurin\LaravelRuleWithScope\Rules\UniqueWithScope;

class RuleWithScopeRuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'laravel-rule-with-scope');
        $this->publishes([
            __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/laravel-rule-with-scope'),
        ], 'lang');

        Validator::extend('unique_with_scope', [UniqueWithScope::class, 'validate']);
        Validator::replacer('unique_with_scope', [UniqueWithScope::class, 'replacer']);
    }

    public function register()
    {
        //
    }
}
