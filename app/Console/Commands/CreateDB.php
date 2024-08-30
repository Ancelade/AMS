<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use InfluxDB\Client;
use PDO;

class CreateDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = '127.0.0.1';
        $root = 'root';

        if (env('DB_HOST') === "127.0.0.1") {


            try {
                $pdo = new PDO("mysql:unix_socket=/var/run/mysqld/mysqld.sock", $root);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Créer la base de données seulement si elle n'existe pas
                $pdo->exec("CREATE DATABASE IF NOT EXISTS ams");

                // Vérifier si l'utilisateur existe déjà
                $result = $pdo->query("SELECT COUNT(*) FROM mysql.user WHERE user = 'ams'");
                $userExists = $result->fetchColumn();

                if (!$userExists) {
                    // Créer l'utilisateur et lui attribuer les permissions si l'utilisateur n'existe pas
                    $pdo->exec("CREATE USER 'ams'@'localhost' IDENTIFIED BY 'ams'");
                    $pdo->exec("GRANT ALL PRIVILEGES ON ams.* TO 'ams'@'localhost'");
                    $pdo->exec("FLUSH PRIVILEGES");
                }

                echo "Base de données créée avec succès et permissions attribuées si nécessaire.";
            } catch (PDOException $e) {
                die("Erreur PDO : " . $e->getMessage());
            }
        }

        Artisan::call('migrate', ['--force' => true]);
        dump("Database is full ready");

        $client = Client::fromDSN('influxdb://' . env('INFLUX_USERNAME') . '@' . env('INFLUX_HOST') . ':' . 8086, 5);
        $databaseList = $client->listDatabases();
        if (!in_array(env('INFLUX_DB'), $databaseList)) { //IF DB EXIST
            $database = $client->selectDB(env('INFLUX_DB'));
            $database->create();
            $this->line('influx database created');
            return;
        }
    }
}
