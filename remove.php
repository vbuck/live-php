<?php

/**
 * Snippet remove mechanism.
 */

$snippet_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'snippets' . DIRECTORY_SEPARATOR;

if (!$_GET['file']) {
    die('No snippet to delete.');
}

if (unlink($snippet_path . $_GET['file'] . '.php')) {
    die('Snippet '. $_GET['file'] . ' deleted.');
}