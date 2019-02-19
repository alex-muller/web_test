<?php declare(strict_types=1);


namespace App\Infrastructure;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

final class DBQueryBuilder
{

    public function getTableQuery($tableName): Builder {
        return DB::table($tableName);
    }

}