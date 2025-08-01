<?php

namespace NurazimZahurin\LaravelRuleWithScope\Rules;

use NurazimZahurin\LaravelRuleWithScope\Rules\Contracts\RuleWithScope;

class UniqueWithScope implements RuleWithScope
{
    /**
     * Get the name of the validation rule.
     *
     * @return string
     */
    public static function name(): string
    {
        return 'unique_with_scope';
    }

    /**
     * Validate the unique rule with scope.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @param \Illuminate\Validation\Validator $validator
     * @return bool
     */
    public static function validate($attribute, $value, $parameters, $validator): bool
    {
        list($modelClass, $column) = $parameters;
        $exceptId = $parameters[2] ?? null;
        $idColumn = $parameters[3] ?? 'id';

        $query = (new $modelClass)->newQuery();
        $query->where($column, $value);

        if ($exceptId !== null) {
            $query->where($idColumn, '<>', $exceptId);
        }

        if ($query->exists()) {
            $validator->setCustomMessages([
                $attribute . '.' . self::name() => 'The ' . str_replace("_", " ", $attribute) . ' has already been taken.',
            ]);
            return false;
        }

        return true;
    }
}
