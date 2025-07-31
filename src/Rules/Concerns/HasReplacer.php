<?php

namespace NurazimZahurin\LaravelRuleWithScope\Rules\Concerns;

trait HasReplacer
{
    public static function replacer(): callable
    {
        return function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, $message);
        };
    }
}
