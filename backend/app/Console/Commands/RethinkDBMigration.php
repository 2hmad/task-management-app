<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use r;

class RethinkDBMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rethinkdb:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate RethinkDB tables and indexes';

    /**
     * The connection to the RethinkDB database.
     *
     * @var \r\Connection
     */
    protected $connection;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Running RethinkDB migrations...');

        # Connect to RethinkDB
        $retries = 5;
        $waitSeconds = 5;

        while ($retries > 0) {
            try {
                $this->connection = r\connect(
                    env('DB_HOST', 'rethinkdb'),
                    env('DB_PORT', 28015)
                );
                break;
            } catch (\Exception $e) {
                echo $e->getMessage() . PHP_EOL;
                $this->error("Failed to connect to RethinkDB. Retrying in {$waitSeconds} seconds...");
                sleep($waitSeconds);
                $retries--;
            }
        }

        if ($retries == 0) {
            throw new \Exception("Could not connect to RethinkDB after multiple attempts.");
        }

        // Example: Create a database
        $this->createDatabase();

        // Example: Create a table
        $this->createTable();

        $this->info('Migrations completed.');
    }

    protected function createDatabase()
    {
        $dbName = env('DB_DATABASE', 'palm_outsourcing');

        try {
            r\dbCreate($dbName)->run($this->connection);
            $this->info("Database `{$dbName}` created.");
        } catch (\Exception $e) {
            $this->warn("Database `{$dbName}` already exists.");
        }
    }

    protected function createTable()
    {
        $dbName = env('DB_DATABASE', 'palm_outsourcing');
        $tableName = env('DB_TABLE', 'tasks');

        try {
            r\db($dbName)->tableCreate($tableName)->run($this->connection);
            $this->info("Table `{$tableName}` created.");
        } catch (\Exception $e) {
            $this->warn("Table `{$tableName}` already exists.");
        }
    }}
