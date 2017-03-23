<?php

/**
 * Code execution handler.
 */

$basePath   = dirname( ( dirname(__FILE__) ) );
$data       = $_POST['livephp'];

if (!empty($data['display_errors'])) {
    ini_set('display_errors', 1);
}

if (!$data['input']) {
    die('No input specified');
}

ob_start();

echo eval($data['input']);

$output = ob_get_contents();

ob_end_clean();

echo $output;

function __snippet ($snippet) {
    $_GET['file'] = $snippet.'.php';

    ob_start();

    require 'load.php';

    $contents = ob_get_contents();

    ob_end_clean();

    eval($contents);
}