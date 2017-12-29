<?php
/** @var modX $modx */
/** @var Looked $Looked */

if (empty($_REQUEST['action'])) {
    die('Access denied');
} else {
    $action = $_REQUEST['action'];
}

define('MODX_API_MODE', true);
/** @noinspection PhpIncludeInspection */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';

$modx->getService('error', 'error.modError');
$modx->getRequest();
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');
$modx->error->message = null;

$Looked = $modx->getService('looked', 'Looked', $modx->getOption('looked_core_path', null,
        $modx->getOption('core_path') . 'components/looked/') . 'model/looked/');

if ($modx->error->hasError() || !($Looked instanceof Looked)) {
    die('Error');
}

switch ($action) {
    case 'looked/remove':
    case 'looked/remove/all':
        $response = $Looked->remove($_REQUEST['resource'], $_REQUEST['id']);
        break;
}
if (is_array($response)) {
    $response = json_encode($response);
}

@session_write_close();
exit($response);