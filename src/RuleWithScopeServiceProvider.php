<?php

namespace Nurazimzahurin\LaravelRuleWithScope;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use NurazimZahurin\LaravelRuleWithScope\Rules\Contracts\RuleWithScope;

class RuleWithScopeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $rulesPath = __DIR__ . '/Rules';

        foreach (scandir($rulesPath) as $file) {
            if (Str::endsWith($file, '.php') && $file !== 'Contracts') {
                $class = __NAMESPACE__ . '\\Rules\\' . pathinfo($file, PATHINFO_FILENAME);

                if (is_subclass_of($class, RuleWithScope::class)) {
                    Validator::extend($class::name(), [$class, 'validate']);
                }
            }
        }
    }
}
