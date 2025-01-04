<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use r;
use Faker\Factory as Faker;

use function r\uuid;

class RethinkDBSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rethinkdb:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed RethinkDB with initial data';

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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        # Connect to RethinkDB
        $retries = 5;
        $waitSeconds = 5;

        while ($retries > 0) {
            try {
                $this->connection = r\connect(
                    env('DB_HOST', 'rethinkdb'),
                    env('DB_PORT', 28015)
                );

                $this->info('Connected to RethinkDB.');

                // Seed the database
                $this->seedDatabase();

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
    }

    /**
     * Seed the RethinkDB database with initial data.
     */
    private function seedDatabase()
    {
        $this->info('Seeding RethinkDB database...');

        // Example: Seed a table
        $this->seedTable();
    }

    /**
     * Seed a RethinkDB table with initial data.
     */
    private function seedTable()
    {
        $this->info('Seeding RethinkDB table...');

        $tableName = 'tasks';

        // Check if the table exists
        if (!r\db(env('DB_DATABASE'))->tableList()->contains($tableName)->run($this->connection)) {
            $this->error("Table '{$tableName}' does not exist. Please create the table before seeding.");
            return;
        }

        $faker = Faker::create();

        // Insert data into the table
        r\db(env('DB_DATABASE'))->table($tableName)->insert([
            'id' => uuid(),
            'title' => $faker->sentence(),
            'description' => $faker->paragraph(),
            'status' => 'pending',
        ])->run($this->connection);

        $this->info('Table seeded successfully.');

        $this->info('RethinkDB seeding complete.');

        // Close the connection
        $this->connection->close();

        $this->info('Connection to RethinkDB closed.');

        return 0;
    }
}
