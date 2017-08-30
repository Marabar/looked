<?php

class Looked {
	/** @var modX $modx */
	public $modx;

	public $pdoTools;


	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('looked_core_path', $config, $this->modx->getOption('core_path') . 'components/looked/');
		$assetsUrl = $this->modx->getOption('looked_assets_url', $config, $this->modx->getOption('assets_url') . 'components/looked/');

        $actionUrl = $assetsUrl . 'action.php';

		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			//'cssUrl' => $assetsUrl . 'css/',
			'jsUrl' => $assetsUrl . 'js/',
            'actionUrl' => $actionUrl,

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'templatesPath' => $corePath . 'elements/templates/',
			'snippetsPath' => $corePath . 'elements/snippets/',
		), $config);

		$this->modx->lexicon->load('looked:default');
	}

	
	public function process(array $scriptProperties, $ids)
    {
		$name = $scriptProperties['snippet'];
		$scriptProperties['resources'] = $ids;
		
		if ($snippet = $this->modx->getObject('modSnippet', array('name' => $name))) {
			$properties = $snippet->getProperties();
			$scriptProperties = array_merge($properties, $scriptProperties);

            $snippet->_cacheable = false;
            $snippet->_processed = false;
            
			$response = $snippet->process($scriptProperties);

            return $response;
        } else {
            return $this->modx->log(modX::LOG_LEVEL_ERROR, $this->modx->lexicon(
                    'looked_err_empty_snippet') . ' ' . $name
            );
        }
	}


    public function getChunk($chunk, $properties = array())
    {
        if ($this->pdoTools = $this->modx->getService('pdoTools')) {
            $response = $this->pdoTools->getChunk($chunk, $properties);
        } else {
            $response = $this->modx->getChunk($chunk, $properties);
        }

        return $response;
    }


    public function remove($resource)
    {
        $id = (int) $resource;
        if ($id) {
            $ids = $_SESSION['looked'];
            if ($key = array_search($id, $ids)) {
                unset($_SESSION['looked'][$key]);
                $count = count($_SESSION['looked']);

                return $this->success('', $count);
            } else {
                return $this->error('looked_err_resource');
            }
        } else {
            unset($_SESSION['looked']);

            return $this->success('', 0);
        }
    }


    public function success($message = '', $count)
    {
        $response = array(
            'success' => true,
            'message' => $this->modx->lexicon($message),
            'count' => $count,
        );

        return $this->config['json_response']
            ? json_encode($response)
            : $response;
    }


    public function error($message = '')
    {
        $response = array(
            'success' => false,
            'message' => $this->modx->lexicon($message),
        );

        return $this->config['json_response']
            ? json_encode($response)
            : $response;
    }

}