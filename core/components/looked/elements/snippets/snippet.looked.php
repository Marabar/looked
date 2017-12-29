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

$output = '';

if (isset($_SESSION['looked']) && !empty($_SESSION['looked'])) {
	$id = $modx->resource->get('id');
	$arrIds = $_SESSION['looked'];
	$count = count($arrIds);
    if(($key = array_search($id, $arrIds)) !== false){
		unset($arrIds[$key]);
        $count = $count - 1;
	}
    $modx->toPlaceholder('count', $count, 'looked');
    $ids = implode(',', $arrIds);
} else {
	return '';
}
if (empty($ids))
    return '';

if ($scriptProperties['ids'] == true) {
	$output = $ids;
} else {
	if ($out = $Looked->process($scriptProperties, $ids)) {
        $output = $Looked->getChunk($scriptProperties['tplOuter'], array('output' => $out));
    }
}

if (!empty($frontendJs)) {
    $modx->regClientScript(MODX_ASSETS_URL . $scriptProperties['frontendJs']);
}
$modx->regClientHTMLBlock('<script>Looked.initialize({ 
    "actionUrl":"' . $Looked->config['actionUrl'] . '",
    "id":"' . $modx->resource->id . '"});
</script>');

return $output;
