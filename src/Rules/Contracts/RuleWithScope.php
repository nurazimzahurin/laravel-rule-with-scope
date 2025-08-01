<?php

namespace NurazimZahurin\LaravelRuleWithScope\Rules\Contracts;

interface RuleWithScope
{
    public static function name(): string;

    public static function validate($attribute, $value, $parameters, $validator): bool;
}
