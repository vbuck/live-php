<?php

/**
 * Snippet load mechanism.
 */

$snippet_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'snippets' . DIRECTORY_SEPARATOR;

if (!isset($_GET['file'])) {
    $snippets = scandir($snippet_path);

    foreach ($snippets as $snippet) {
        if (substr($snippet, 0, 1) == '.') {
            continue;   
        }

        ?>
        <option value="<?php echo $snippet; ?>"><?php echo preg_replace('/\.php$/','',$snippet); ?></option>
        <?php
    }

    exit;
}

$snippet = urldecode($_GET['file']);

if (!file_exists($snippet_path . $snippet)) {
    die('Snippet not found');
}

readfile($snippet_path . $snippet);