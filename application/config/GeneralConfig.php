<?php

// config class
require SERVER . '/Config.php';

define('SITE_NAME', 'Simple Zillow');
define('TIMESTAMP', rand(0,100000000));

define('FOLDER_VIEWS',       ABS_BASE_PATH . 'application/views/');
define('FOLDER_CONTROLLERS', ABS_BASE_PATH . 'application/controllers/');
define('FOLDER_MODELS',      ABS_BASE_PATH . 'application/models/');
define('FOLDER_TEMPLATES',   ABS_BASE_PATH . 'public/templates/');
define('FOLDER_JS',          ABS_BASE_PATH . 'public/js/');
define('FOLDER_CSS',         ABS_BASE_PATH . 'public/css/');
define('FOLDER_IMAGES',      ABS_BASE_PATH . 'public/images/');
define('FOLDER_FONTS',       ABS_BASE_PATH . 'public/fonts/');
define('FOLDER_SCRIPTS',     ABS_BASE_PATH . 'scripts/');
define('FOLDER_LIBRARY',     ABS_BASE_PATH . 'library/');
define('FOLDER_DATA',        ABS_BASE_PATH . 'data/');
define('FOLDER_LOGS',        ABS_BASE_PATH . 'data/logs/');
define('FOLDER_BACKUPS',     ABS_BASE_PATH . 'data/backups/');

define('ZILLOW_KEY', 'X1-ZWz1ghhd0anevf_5upah');

define('SITE_JS',  SITE_URL . 'public/js/');
define('SITE_CSS', SITE_URL . 'public/css/');

Database::init(DB_USER, DB_PASS, DB_NAME, DB_HOST, DB_PORT);

SessionData::start();