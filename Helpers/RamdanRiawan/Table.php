<?php

namespace RamdanRiawan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Table
{
    public static function getEnum(Model $model, $column): array
    {

        $enumValues = collect(DB::select("SHOW COLUMNS FROM {$model->getTable()} WHERE Field = '$column'"))
            ->pluck('Type') // ambil tipe kolom, misalnya: enum('draft','published','archived')
            ->first();

        preg_match("/^enum\('(.*)'\)$/", $enumValues, $matches);

        $values = isset($matches[1])
            ? explode("','", $matches[1])
            : [];

        return $values;
    }

    public static function getColumn(Model $model): array
    {
        $columns = Schema::getColumnListing(($model)->getTable());

        return $columns;
    }
}
