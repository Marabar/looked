<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var Looked $Looked */

if (!$Looked = $modx->getService('looked', 'Looked', $modx->getOption('looked_core_path',
        null, $modx->getOption('core_path') . 'components/looked/') . 'model/looked/',
    $scriptProperties)
) {
    return '';
}

$templates = $modx->getOption('templates', $scriptProperties, '');
$limit = $modx->getOption('limit', $scriptProperties, '5');

$id = $modx->resource->id;
$template = $modx->resource->template;
$arrTemplate = !empty($templates)
	? explode(',', str_replace(' ', '', $templates))
	: array();

if (empty($arrTemplate) || in_array($template, $arrTemplate)) {
	if (!isset($_SESSION['looked'])) {
		$_SESSION['looked'] = array();
		$_SESSION['looked'][] = $id;
	} else {
		if (in_array($id, $_SESSION['looked']) === false) {
			array_unshift($_SESSION['looked'], $id);
		}
		if (count($_SESSION['looked']) > $limit) {
			array_pop($_SESSION['looked']);
		}
	}
	return;
}
return;
