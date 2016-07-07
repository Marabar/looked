<?php

$properties = array();

$tmp = array(
	'tpl' => array(
		'type' => 'textfield',
		'value' => 'lookedTpl',
	),
	'tplOuter' => array(
		'type' => 'textfield',
		'value' => 'lookedOuterTpl',
	),
	'snippet' => array(
		'type' => 'textfield',
		'value' => 'msProducts',
	),
	'limit' => array(
		'type' => 'numberfield',
		'value' => 5,
	),
	'ids' => array(
		'type' => 'combo-boolean',
		'value' => false,
	),
	'parents' => array(
		'type' => 'numberfield',
		'value' => 0,
	),
	'sortdir' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'sortby' => array(
		'type' => 'textfield',
		'value' => '',
	),
);

foreach ($tmp as $k => $v) {
    $properties[] = array_merge(
        array(
            'name' => $k,
            'desc' => PKG_NAME_LOWER . '_prop_' . $k,
            'lexicon' => PKG_NAME_LOWER . ':properties',
        ), $v
    );
}

return $properties;