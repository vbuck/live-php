<?php

/**
 * Snippet save mechanism.
 */

$snippet_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'snippets' . DIRECTORY_SEPARATOR;

$data = $_POST['livephp'];

$fp = fopen($snippet_path . $data['snippet_name'] . '.php', 'w') OR die('Failed to save: write error.');

flock($fp, LOCK_EX);
fputs($fp, $data['input']);
flock($fp, LOCK_UN);
fclose($fp);

die('Snippet saved.');