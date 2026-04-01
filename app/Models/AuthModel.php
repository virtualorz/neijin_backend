<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Jsadways\ScopeFilter\ScopeFilterTrait;

abstract class AuthModel extends Authenticatable
{
    use HasFactory, ScopeFilterTrait;

    public function __construct(array $attributes = [])
    {
        $this->fillable = array_keys($this->_schema());
        parent::__construct($attributes);
    }

    abstract protected function _schema(): array;

    public static function get_schema(array $select = null, array $ignore = null): array
    {
        $model_schema = (new static)->_schema();
        $validation = ['id' => 'required|integer', ...$model_schema];
        return static::_pick_schema($validation, $select, $ignore);
    }

    private static function _pick_schema(array $all_schema, ?array $select, ?array $ignore): array
    {
        $columns = [];
        if ($select) {
            $columns = array_intersect(array_keys($all_schema), $select);
        } elseif ($ignore) {
            $columns = array_diff(array_keys($all_schema), $ignore);
        }

        $choose = [];
        foreach ($columns as $column) {
            $choose[$column] = $all_schema[$column];
        }
        return !empty($choose) ? $choose : $all_schema;
    }
}
