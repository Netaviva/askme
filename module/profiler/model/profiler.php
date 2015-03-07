<?php defined('LINKO') or exit;

/**
 * @package Profiler
 * @author Morrison Laju <morrelinko@gmail.com>
 */
class Profiler_Model_Profiler extends Linko_Model
{
	public function get()
	{
		Linko::Profiler()->extend('file', $this->_getFileData());
		
		if(isset($_SESSION))
		{
			Linko::Profiler()->extend('session', $this->_arrayDump(Linko::Session()->get()));	
		}
		
		Linko::Profiler()->extend('request', array(
				'info' => array(
					'Total $GET' => count(Linko::Request()->getGET()),
					'Total $POST' => count(Linko::Request()->getPOST())
				),
				'GET' => $this->_arrayDump(Linko::Request()->getGET()),	
				'POST' => $this->_arrayDump(Linko::Request()->getPOST()),	
				'SERVER' => $this->_arrayDump($_SERVER),
				'ENV' => $this->_arrayDump($_ENV),		
			)
		);

        $aObjects = Linko_Object::getObjects();

		Linko::Profiler()->extend('framework', array(
				'info' => array(
					'total_classes_called' => count($aObjects),
				),
				'classes' => $aObjects,
				'config' => $this->_arrayDump(Linko::Config()->getConfig()),
			)
		);
				
		$sUri = Linko::Request()->getUri();
		$oInfo = Linko::Router()->getInfo();
		$oRoute = $oInfo->route;
		
		Linko::Profiler()->extend('route', array(
				'info' => array(
					'Route ID' => $oInfo ? $oInfo->id : null,
                    'Route Pattern' => $oRoute ? htmlentities($oRoute->getRawRegex()) : null,
					'Route Regex' => $oRoute ? $oRoute->getRegex() : null,
					'Controller' => $oInfo->controller,
					'Request Uri' => $sUri == '' ? '/' : $sUri,
				),
				'routes' => (array)Linko::Router()->getRoutes()
			)
		);

        $aStyles = array_merge(Linko::Template()->getStyle('header', true));
        $aScripts = array_merge(Linko::Template()->getScript('header', true), Linko::Template()->getScript('footer', true));

        Linko::Profiler()->extend('asset', array(
                'info' => array(
                    'Total Loaded Styles' => count($aStyles),
                    'Total Loaded Script' => count($aScripts),
                ),
                'styles' => $aStyles,
                'scripts' => $aScripts,
            )
        );
				
		return Linko::Profiler()->getDetails();
	}
	
	private function _arrayDump($mVar = null, $iDepth = 0, &$iCnt = 0)
	{
		$sResult = '';
		$sType = gettype($mVar);
		
		if(in_array($sType, array('object', 'array')))
		{
			foreach($mVar as $sKey => $mVal)
			{
				$iCnt++;
				
				$sResult .= Html::tag('tr',
					Html::tag('td', 
						Html::tag('b', str_repeat(' &rsaquo; &nbsp; ', $iDepth), array('style' => 'color: #00aa00')) . 
						$sKey . 
						Html::tag('span', (is_array($mVal) ? null : $mVal), array('class' => 'profiler-right'))
					)
				);
				
				$sResult .= is_array($mVal) ? $this->_arrayDump($mVal, ($iDepth + 1), $iCnt) : null;				
			}
		}
		
		return $sResult;
	}
	
	private function _getFileData()
	{
		$aIncludedFiles = get_included_files();	
		$aFiles = array();
		$iTotalCount = 0;
		$iTotalSize = 0;
		$iMaxSize = 0;
		$sMaxFile = null;
		
		foreach($aIncludedFiles as $sFile)
		{
			$iSize = filesize($sFile);
			
			$aFiles[] = array(
				'file' => $sFile,
				'size' => Number::size($iSize),
			);
			
			if($iSize > $iMaxSize)
			{
				$iMaxSize = $iSize;
				$sMaxFile = $sFile;	
			}
			else
			{
				$iMaxSize = $iMaxSize;
				$sMaxFile = $sMaxFile;
			}
			
			$iTotalSize += $iSize;
			$iTotalCount++;
		}
		
		return array(
			'files' => $aFiles,
			'info' => array(
				'total_files' => $iTotalCount,
				'largest_file' => $sMaxFile,
				'largest_file_size' => Number::size($iMaxSize),
				'total_file_size' => Number::size($iTotalSize)
			)
		);			
	}
}

?>