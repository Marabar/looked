<?php

if (!$Looked = $modx->getService('looked', 'Looked', $modx->getOption('looked_core_path', null, $modx->getOption('core_path') . 'components/looked/') . 'model/looked/', $scriptProperties)) {
	return 'Could not load Looked class!';
}

if (isset($_SESSION['looked']) && !empty($_SESSION['looked'])) {
	$id = $modx->resource->get('id');
	$arrIds = $_SESSION['looked'];
    $modx->toPlaceholder('count', count($arrIds), 'looked');
	if(($key = array_search($id, $arrIds)) !== false){
		unset($arrIds[$key]);
	}
    $ids = implode(',', $arrIds);
}
else {
	return;
}
if (empty($ids))
    return;

$output = '';

if ($scriptProperties['ids'] == true) {
	$output = $ids;
}
else {
	$out = $Looked->process($scriptProperties, $ids);
	$output = $Looked->getChunk($scriptProperties['tplOuter'], array('output' => $out));
}

return $output;
