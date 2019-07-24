<?php

namespace App\RedisIronMan;

use Illuminate\Support\Facades\Redis;

class RedisIronMan
{
    private $setDatabase;

    public function setDatabase(array $database)
    {
        $this->setDatabase = $database;

        return $this;
    }

    public static function resetDatabase()
    {
        Redis::select(env('REDIS_DB'));
    }

    public function doAction(\Closure $closure)
    {
        foreach($this->setDatabase as $database) {
            Redis::select($database);
            $closure();
        }
    }
}