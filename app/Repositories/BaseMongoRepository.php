<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

/**
 * Class BaseRepository.
 */
class BaseMongoRepository
{
    protected $connection = 'mongodbapace';

    protected function getDB()
    {
        if (!$this->connection) {
            $this->connection = config('database.mongodb_primary');
        }
        return DB::connection($this->connection);
    }

    protected function getCollection($collection_name)
    {
        return $this->getDB()->collection($collection_name);
    }

    public static function getConnection()
    {
        return DB::connection(config('database.mongodb_primary'));
    }

}
