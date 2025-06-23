<?php
// Set up error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load configuration
$env = parse_ini_file('.env');
foreach ($env as $key => $value) {
    putenv("$key=$value");
}

// Define constants
define('CURRENCY', getenv('CURRENCY_SYMBOL'));
define('APP_URL', getenv('APP_URL'));

// Include necessary files
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/Car.php';
require_once __DIR__ . '/includes/CarController.php';
require_once __DIR__ . '/includes/User.php';
require_once __DIR__ . '/includes/AuthController.php';

// Start session
session_start();
