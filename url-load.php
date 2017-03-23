<?php

/**
 * Snippet URL load mechanism.
 */

$snippet_path   = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'snippets' . DIRECTORY_SEPARATOR;
$base           = dirname($_SERVER['SCRIPT_NAME']) . '/load/';
$_snippet       = str_replace($base, '', $_SERVER['REQUEST_URI']);
$snippet        = base64_decode($_snippet) . '.php';

if (file_exists($snippet_path . $snippet)) {
    echo "<script type='text/javascript'>load('{$snippet}');</script>";
}