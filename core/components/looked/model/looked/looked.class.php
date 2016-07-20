<?php

class Looked {
	/** @var modX $modx */
	public $modx;


	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('looked_core_path', $config, $this->modx->getOption('core_path') . 'components/looked/');
		//$assetsUrl = $this->modx->getOption('looked_assets_url', $config, $this->modx->getOption('assets_url') . 'components/looked/');
		//$connectorUrl = $assetsUrl . 'connector.php';

		$this->config = array_merge(array(
			//'assetsUrl' => $assetsUrl,
			//'cssUrl' => $assetsUrl . 'css/',
			//'jsUrl' => $assetsUrl . 'js/',
			//'imagesUrl' => $assetsUrl . 'images/',
			//'connectorUrl' => $connectorUrl,

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'templatesPath' => $corePath . 'elements/templates/',
			//'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath . 'elements/snippets/',
			//'processorsPath' => $corePath . 'processors/',
		), $config);

		$this->modx->lexicon->load('looked:default');
	}
	
	
	public function getChunk($name, $properties = array()) {
                $chunk = NULL;
                
                if (!isset($this->chunks[$name])) {
                        $chunk = $this->modx->getObject('modChunk', array('name' => $name));
                        
                        if (empty($chunk) || !is_object($chunk)) {
                                $chunk = $this->_getTplChunk($name);
                                
                                if ($chunk == FALSE)  return FALSE;
                        }
                        
                    $this->chunks[$name] = $chunk->getContent();
                }
                else {
                        $o = $this->chunks[$name];
                        $chunk = $this->modx->newObject('modChunk');
                        $chunk->setContent($o);
                }
                $chunk->setCacheable(FALSE);

                return $chunk->process($properties);
        }
	
	
	private function _getTplChunk($name) {
                $chunk = FALSE;
		$postfix = 'chunk.'. strtolower($name). '.tpl';
                
                $f = $this->config['chunksPath'] . $postfix;
                
                if (file_exists($f)) {
                        $o = file_get_contents($f);
                        $chunk = $this->modx->newObject('modChunk');
                        $chunk->set('name', $name);
                        $chunk->setContent($o);
                }
                
                return $chunk;
        }
	
	
	public function process(array $scriptProperties, $ids) {
		
		$name = $scriptProperties['snippet'];
		$scriptProperties['resources'] = $ids;
		
		if ($snippet = $this->modx->getObject('modSnippet', array('name' => $name))) {
			$properties = $snippet->getProperties();
			$scriptProperties = array_merge($properties, $scriptProperties);
            
			$response = $snippet->process($scriptProperties);
			
		}
        
		return $response;
	}

}