<?php

/**
 * add a log entry
 *
 * @param  int    $severity [ level of severity integer ]
 * @param  string $message  [ log message ]
 * @param  string $user     [ client type ]
 * @return void
 */
function logger($severity, $message, $user = 'user') {
    $logger = new Logger();
    $logger->log($severity, $message, $user = 'user');
}

/**
 * redirect the page to a new location
 *
 * @param string $address [ site location url ]
 * @return void
 */
function redirect($address) {
    header('Location: ' . $address);
    die();
}

/**
 * load a view file
 *
 * @param string $view [ name of view file ]
 * @param string $data [ data to be used in the view ]
 * @return void
 */
function loadView($view, $data = array()) {
    $viewFile = '';

    if ( !empty($view) ) {
        $view = strtolower($view);
        $viewFile = FOLDER_VIEWS . $view . '.html';
    } else {
        loadError();
    }

    if ( !file_exists($viewFile) ) {
        return;
    }

    $moduleFolder = explode('/', $view)[0];

    extract((array)$data);

    if ( defined('SERVER"') && SERVER == 'live' ) {
        ob_start('ob_gzhandler');
    }

    include strtolower($viewFile);

    if ( defined('SERVER"') && SERVER == 'live' ) {
        ob_end_flush();
    }
}

/**
 * redirect to error page
 *
 * @return void
 */
function loadError() {
    redirect(SITE_URL . 'error');
}

/**
 * load all javascript files associated with the controller page
 *
 * @return void
 */
function loadJS() {
    // load global JS files
    $filePath = FOLDER_JS . '*.js';

    foreach(glob($filePath) as $file) {
        $file = SITE_JS . basename($file) . '?v=' . TIMESTAMP;
        echo '<script src="' . $file . '"></script>';
    }
}

/**
 * load a HTML file
 *
 * @param  string $filePath [ path of html file ]
 *
 * @return void
 */
function loadFile($filePath) {
    if ( file_exists($filePath) ) {
        include $filePath;
    }
}