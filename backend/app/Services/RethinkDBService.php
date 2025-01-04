<?php

namespace App\Services;

use r;

class RethinkDBService
{
    protected $connection;

    public function __construct()
    {
        $this->connection = r\connect(env('DB_HOST', 'rethinkdb'), env('DB_PORT', 28015));
        $this->createTasksTableIfNotExists();
    }

    protected function createTasksTableIfNotExists()
    {
        $tables = r\db(env('DB_DATABASE', 'palm_outsourcing'))->tableList()->run($this->connection);

        if (!in_array(env('DB_TABLE', 'tasks'), $tables)) {
            r\db(env('DB_DATABASE', 'palm_outsourcing'))
                ->tableCreate(env('DB_TABLE', 'tasks'))
                ->run($this->connection);

            r\db(env('DB_DATABASE', 'palm_outsourcing'))
                ->table(env('DB_TABLE', 'tasks'))
                ->insert([
                    'id' => r\uuid(),
                    'title' => '',
                    'description' => '',
                    'status' => ''
                ])
                ->run($this->connection);
        }
    }

    public function getTasks(): array
    {
        $cursor = r\db(env('DB_DATABASE', 'palm_outsourcing'))
            ->table(env('DB_TABLE', 'tasks'))
            ->run($this->connection);

        return $cursor->toArray();
    }
}
