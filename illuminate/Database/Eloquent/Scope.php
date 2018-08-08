<?php

namespace WpPluginner\Illuminate\Database\Eloquent;

interface Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \WpPluginner\Illuminate\Database\Eloquent\Builder  $builder
     * @param  \WpPluginner\Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model);
}
