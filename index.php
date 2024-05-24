<?php declare(strict_types=1);

use Dotenv\Dotenv;
use models\Database;

require_once realpath(__DIR__ . '/vendor/autoload.php');
$env = Dotenv::createImmutable(__DIR__);
$env->load();
$host     = $_ENV['DB_HOST'];
$db       = $_ENV['DB_NAME'];
$user     = $_ENV['DB_USER'];
$pass     = $_ENV['DB_PASS'];
$database = new Database($host, $db, $user, $pass);
$pdo      = $db->createConnection();

