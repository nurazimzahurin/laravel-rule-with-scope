<?php

namespace NurazimZahurin\LaravelRuleWithScope\Rules;

use NurazimZahurin\LaravelRuleWithScope\Rules\Concerns\HasReplacer;

class UniqueWithScope
{
    use HasReplacer;

    /**
     * Validate the unique_with_scope rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @param \Illuminate\Validation\Validator $validator
     * @return bool
     */
    public function validate($attribute, $value, $parameters, $validator)
    {
        list($modelClass, $column) = $parameters;
        $exceptId = $parameters[2] ?? null;
        $idColumn = $parameters[3] ?? 'id';

        $query = (new $modelClass)->newQuery();
        $query->where($column, $value);

        if ($exceptId !== null) {
            $query->where($idColumn, '<>', $exceptId);
        }

        return !$query->exists();
    }
}
