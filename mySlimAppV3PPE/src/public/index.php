<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Require application bootstrap
require __DIR__ . '/bootstrap/app.php';

// Run Slim
$app->run();