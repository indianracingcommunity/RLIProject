<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

trait Queryable
{
    protected static $defaultProhibitedfields = ['id', 'email', 'remember_token', 'api_token'];

    /**
     * Scope a query to permit filters in query params
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeFilter($query, $request)
    {
        $filterableFields = self::getFilterableFields();
        foreach ($filterableFields as $field) {
            if ($request->filled($field)) {
                $query = $query->where($field, $request->query($field));
            }
        }

        return $query;
    }

    /**
     * Scope a query to return specific permitted columns, from query params
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeSelectable($query, $request)
    {
        if (!$request->filled('fields'))
            return $query;

        $requestedFields = explode(",", $request->query('fields'));
        $modelFields = self::getColumnListing();

        $allowedModelFields = array_diff($modelFields, self::getProhibitedFields());
        $selectedFields = array_intersect($allowedModelFields, $requestedFields);

        return $query->select($selectedFields);
    }

    protected static function getColumnListing()
    {
        return Schema::getColumnListing(with(new static())->getTable());
    }

    // By default, all fields are filterable
    protected static function getFilterableFields()
    {
        return (isset(static::$filterableFields)) ? static::$filterableFields : [];     // phpcs:ignore
    }

    // By default, no fields are prohibited
    protected static function getProhibitedFields()
    {
        return (isset(static::$prohibitedFields)) ? static::$prohibitedFields : self::$defaultProhibitedfields;
    }
}
