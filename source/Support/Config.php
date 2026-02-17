<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

/**
 * DATABASE
 */
define("CONFIG_DB_HOST", $_ENV['db_host']);
define("CONFIG_DB_USER", $_ENV['db_user']);
define("CONFIG_DB_PASS", $_ENV['db_pass']);
define("CONFIG_DB_NAME", $_ENV['db_name']);
define("CONFIG_DB_PORT", $_ENV['db_port']);

/**
 * URLS
 */
define("CONFIG_URL_BASE", "https://www.fsphpmvc.com.br");
define("CONFIG_URL_TEST", "http://localhost/upinside/fsphp-mvc");
define("CONFIG_URL_ADMIN", CONFIG_URL_BASE . "/admin");
define("CONFIG_URL_ERROR", CONFIG_URL_BASE . "/404");

/**
 * DATES
 */
define("CONFIG_DATE_BR", "d/m/Y H:i:s");
define("CONFIG_DATE_APP", "Y-m-d H:i:s");

/**
 * SESSION
 */
define("CONFIG_SESSION_PATH", __DIR__ .  "/../../storage/sessions");

/**
 * PASSWORD
 */
define("CONFIG_PASSWORD_MIN_LENGHT", 8);
define("CONFIG_PASSWORD_MAX_LENGHT", 40);
define("CONFIG_PASSWORD_ALGO", PASSWORD_DEFAULT);
define("CONFIG_PASSWORD_OPTIONS", ["cost" => 10]);

/**
 * MESSAGES
 */
define("CONFIG_MESSAGE_CLASS", "trigger");
define("CONFIG_MESSAGE_INFO", "info");
define("CONFIG_MESSAGE_SUCESS", "success");
define("CONFIG_MESSAGE_WARNING", "warning");
define("CONFIG_MESSAGE_ERROR", "error");


/**
 * UPLOAD
 */
define("CONFIG_UPLOAD_DIR", "../storage/uploads");
define("CONFIG_UPLOAD_IMAGE_DIR", "images");
define("CONFIG_UPLOAD_FILE_DIR", "files");
define("CONFIG_UPLOAD_MEDIA_DIR", "medias");


/**
 * IMAGES
 */
define("CONFIG_IMAGE_CACHE", CONFIG_UPLOAD_DIR . "/" . CONFIG_UPLOAD_IMAGE_DIR . "/cache");
define("CONFIG_IMAGE_SIZE", 2000);
define("CONFIG_IMAGE_QUALITY", ['jpg' => 75, 'png' => 5]);


/**
 * VIEWS
 */
define("CONFIG_VIEW_PATH", __DIR__ . "/../assets/views");
define("CONFIG_VIEW_EXTENSION", __DIR__ . "php");
define("CONFIG_VIEW_THEME", "cafecontrol");


/**
 * EMAIL
 */
define("CONFIG_EMAIL_FROM_EMAIL", $_ENV["email"]);
define("CONFIG_EMAIL_FROM_NAME", $_ENV["name"]);