<?php

$basePath   = dirname( ( dirname(__FILE__) ) );
$data       = $_POST['livephp'];

if (!empty($data['display_errors'])) {
    ini_set('display_errors', 1);
}

if (!$data['input']) {
    die('No input specified');
}

if ($data['use_mage']) {
    $mageRoot = $basePath . DIRECTORY_SEPARATOR . $data['use_mage'] . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Mage.php';
    $mageRoot2 = $basePath . DIRECTORY_SEPARATOR . $data['use_mage'] . DIRECTORY_SEPARATOR . 'magento' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Mage.php';
    $mageRoot3 = $basePath . DIRECTORY_SEPARATOR . $data['use_mage'] . DIRECTORY_SEPARATOR . 'store' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Mage.php';
    $mageRoot4 = $basePath . DIRECTORY_SEPARATOR . $data['use_mage'] . DIRECTORY_SEPARATOR . 'shop' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Mage.php';

    if (!file_exists($mageRoot)) {
        if (!file_exists($mageRoot2)) {
            if (!file_exists($mageRoot3)) {
                if (!file_exists($mageRoot4)) {
                    die("Magento not found at `{$mageRoot4}`");
                } else {
                    $mageRoot = $mageRoot4;
                }
            } else {
                $mageRoot = $mageRoot3;
            }
        } else {
            $mageRoot = $mageRoot2;
        }
    }

    require_once($mageRoot);

    Varien_Profiler::enable();

    Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
}

ob_start();

echo eval($data['input']);

$output = ob_get_contents();

ob_end_clean();

echo $output;

function __snippet($snippet) {
    $_GET['file'] = $snippet.'.php';

    ob_start();

    require 'load.php';

    $contents = ob_get_contents();

    ob_end_clean();

    eval($contents);
}
