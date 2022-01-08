<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  RLIProject - Official IRC Website
 *
 * @author   Kapil Bharath <kapilace6@gmail.com>
 * @author   Kalpesh Choudhary <thekc66@gmail.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

ini_set('max_execution_time', 300);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

require_once __DIR__ . '/public/index.php';
