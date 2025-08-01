<?php

namespace NurazimZahurin\LaravelRuleWithScope\Rules;

use NurazimZahurin\LaravelRuleWithScope\Rules\Contracts\RuleWithScope;

class ExistsWithScope implements RuleWithScope
{
    /**
     * Get the name of the validation rule.
     *
     * @return string
     */
    public static function name(): string
    {
        return 'exists_with_scope';
    }

    /**
     * Validate the exists rule with scope.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @param \Illuminate\Validation\Validator $validator
     * @return bool
     */
    public static function validate($attribute, $value, $parameters, $validator): bool
    {
        if (count($parameters) < 2) {
            return false;
        }

        list($modelClass, $column) = $parameters;

        $query = (new $modelClass)->newQuery();

        $query->where($column, $value);

        $scopeParams = array_slice($parameters, 2);

        for ($i = 0; $i < count($scopeParams); $i += 2) {
            $key = $scopeParams[$i] ?? null;
            $val = $scopeParams[$i + 1] ?? null;

            if ($key && $val !== null) {
                $query->where($key, $val);
            }
        }

        if (!$query->exists()) {
            $validator->setCustomMessages([
                $attribute . '.' . self::name() => 'The selected ' . str_replace("_", " ", $attribute) . ' is invalid.',
            ]);
            return false;
        }

        return true;
    }
}
