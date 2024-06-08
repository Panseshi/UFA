<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$adminPages = explode(',', getenv('ADMIN_PAGES'));
$currentPage = basename($_SERVER['PHP_SELF']);

if (in_array($currentPage, $adminPages)) {
    if (!function_exists('isAdmin')) { // Check if the function exists
        function isAdmin() {
            // Example check - implement your own logic
            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                return true;
            }
            return false;
        }
    }

    if (!isAdmin()) {
        header('Location: login.php');
        exit();
    }
}

// Define the base URL of your site
define('BASE_URL', '/UFA/');

// Define path for assets if not already defined
if (!defined('ASSETS_PATH')) {
    define('ASSETS_PATH', BASE_URL . 'assets/');
}

// Define path for pages if not already defined
if (!defined('PAGES_PATH')) {
    define('PAGES_PATH', ASSETS_PATH . 'pages/');
}
