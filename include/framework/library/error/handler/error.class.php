<?php

class Linko_Error_Handler
{
	private $_aStyle = array(
		'function' => '{:function:}',
		'arg_numeric' => '{:arg_numeric:}',
		'arg_bool' => '{:arg_bool:}',
		'arg_null' => '{:arg_null:}',
		'arg_str' => '"{:arg_str:}"',
	);
	
	private $_aTypes = array(
		1   	=>  "Error",
		2   	=>  "Warning",
		4   	=>  "Parsing Error",
		8   	=>  "Notice",
		16  	=>  "Core Error",
		32  	=>  "Core Warning",
		64  	=>  "Compile Error",
		128 	=>  "Compile Warning",
		256 	=>  "User Error",
		512 	=>  "User Warning",
		1024	=>  "User Notice",
		2048	=>  "PHP 5"	
	);

	private $_aTypeColors = array(
		1   	=>  "#FF9999",
		2   	=>  "#00FFFF",
		4   	=>  "#FF9999",
		8   	=>  "#99FF99",
		16  	=>  "#FF9999",
		32 		=>  "#00FFFF",
		64  	=>  "#FF9999",
		128 	=>  "#00FFFF",
		256 	=>  "#FF9999",
		512 	=>  "#00FFFF",
		1024	=>  "#FF9999",
		2048	=>  "#FF9999"
	);
			
	public function handle($iCode, $sMsg, $sFile, $iLine, $aContext)
	{
		/* Do not display errors when we are in production/live mode, we preferably log errors */
		if(!error_reporting() || (MODE !== 'dev'))
		{
			return false;	
		}

		$aTrace = $this->_trace(1, 10);

   		if (preg_match('/' . implode('|', array('mysql_connect', 'mysqli_connect')) . '\(\)/i', $sMsg))
   		{			
			ob_clean();
			//die('Database Error');
			
   			$aTrace =  $this->_trace(1, 2);
   		}
		
		$sErr = '<!-- Error Generated By LinkoFramework -->';
		$sErr .= '<div style="background-color: #455016; font-family: Verdana; font-weight: bold; margin-bottom: 2px; color: #fff; padding: 10px;">LinkoFramework Error</div>';
		$sErr .= '<div style="font-family:Verdana;font-size:12px; border: 1px solid #ccc; background:#f7f8f7; padding: 10px;">';
	    $sErr .= '<div style="background-color: ' . $this->_aTypeColors[$iCode] . '; padding: 10px; margin-bottom: 10px;"><b>' . $this->_aTypes[$iCode] . ':&nbsp;' . $sMsg . ' - ' . $sFile . ' (' . $iLine . ')</b></div>';
		
		$iCnt = 0;
		foreach($aTrace as $i => $mTrace)
		{
			$iCnt++;
			$sErr .= '<div style="width: 100%; border: 1px solid #ccc; background: #fff;' . ($iCnt != count($aTrace) ? 'margin-bottom: 10px;' : '') . '">';
			$sErr .= '<div style="padding: 20px; ">';
            $sErr .= '<p>[' . $i . '] File: ' . $mTrace['file'] . '</p>';
			$sErr .= '<p>Line: ' . $mTrace['line'] . '</p>';
            $sErr .= str_replace('&lt;?php&nbsp;', '', highlight_string("<?php " . $mTrace['function'], true));
			$sErr .= '</div>';
			$sErr .= '</div>';
		}
		
		$sErr .= '</div>';
		$sErr .= '<div style="font-family: verdana; font-size: 12px; color: #999; text-align: right; margin-top: 5px; border-top: 1px solid #ccc; padding: 10px; ">LinkoFramework by Linkodev</div>';
		echo $sErr;
		
		exit;
	}
	
	private function _trace($iStart, $iDepth)
	{
		$aStackTrace = array();
		$aTrace = debug_backtrace(true);
		
		$iEnd = sizeof($aTrace);
		
		for($i = $iStart; $i < $iDepth && $i < $iEnd; ++$i)
		{
        	if (!isset($aTrace[$i]['file']))
        	{
        		continue;
        	}
			
			if(isset($aTrace[$i]['class']) && ($aTrace[$i]['class'] == 'Linko_ErrorHandler'))
			{
				continue;
			}
			
        	if ($aTrace[$i]['function'] == 'trigger_error' || $aTrace[$i]['function'] == 'trigger')
        	{
        		continue;
        	} 
			
    		$sArgs = '';
        	if (isset($aTrace[$i]['args']))
        	{
            	$aArgs = array();
            	$aArgs = array_merge($aTrace[$i]['args'], array());
            	if ($aArgs and is_array($aArgs))
            	{
                	foreach ($aArgs as $k=>$v)
                	{
                    	if (is_numeric($v))
                    	{
                    	    $aArgs[$k] = $this->_html($v, 'arg_numeric') ;
                    	}
                    	elseif(is_bool($v))
                    	{
                    	    $aArgs[$k] = $this->_html($v ? 'TRUE' : 'FALSE', 'arg_bool');
                    	}
                    	elseif(is_null($v))
                    	{
							$aArgs[$k] = $this->_html('NULL', 'arg_null');
                    	}
                    	elseif(is_array($v))
                    	{
                    	    $aArgs[$k] = 'Array('.count($v).')';
                    	}
    	                elseif (is_string($v) && ! (('"' == substr($v,0,1)) && ('"' == substr($v,-1))))
	                    {
	                        $aArgs[$k] = $this->_html($v, 'arg_str');
	                    }
	                    elseif(is_object($v))
	                    {
	                        unset($aArgs[$k]);
	                        $aArgs[$k] = '{' . ucfirst(get_class($v)) . '}';
	                    }
	                }
	            }
	            $sArgs = implode(', ', $aArgs);
	        }
						
			$sFuncName = (isset($aTrace[$i]['class']) ? $aTrace[$i]['class'] : '') . 
							(isset($aTrace[$i]['type']) ? $aTrace[$i]['type'] : '').
                     			$aTrace[$i]['function'].'('.$sArgs.')';	

        	if ($iStart == $i)
        	{

        	}
			
			$sFuncName = $this->_html($sFuncName, 'function');
			$sFile = $aTrace[$i]['file'];
			
			$aStackTrace[] = array(
				'file' => $sFile,
				'line' => (isset($aTrace[$i]['line']) ? $aTrace[$i]['line'] : ''),
				'function' => $sFuncName
			);		
		}
		
		return $aStackTrace;
	}

	public function log($sMessage, $sFile, $iLine)
	{
		if(!Dir::exists(Linko::Config()->get('dir.log')))
		{
			return;	
		}
		
		$aCallbacks = debug_backtrace();
		$aBacktrace = array();
		foreach ($aCallbacks as $aCallback)
		{
			if (isset($aCallback['class']) && $aCallback['class'] == 'Linko_Error')
			{
				continue;
			}
			
			if (!isset($aCallback['file']) || !isset($aCallback['line']))
			{
				continue;
			}
			
			$aBacktrace[] = array(
				'file' => $aCallback['file'],
				'line' => $aCallback['line']
			);
		}	    
		
		$sErrorLog = serialize(array(
				'message' => $this->_escapeCdata($sMessage),
				'backtrace' => var_export($aBacktrace, true),
				'request' => var_export($_REQUEST, true),
				'ip' => $_SERVER['REMOTE_ADDR']
			)
		);
		
		$hFile = fopen(Linko::Config()->get('dir.log') . 'php_error_log_' . date('d_m_y', time()) . '_' . Linko::Config()->get('Ext.log'), 'a');
    	fwrite($hFile, "##\n{$sErrorLog}##\n");
    	fclose($hFile);		
	}

	private function _escapeCdata($sXml)
	{
		$sXml = preg_replace('#[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]#', '', $sXml);

		return str_replace(array('<![CDATA[', ']]>'), array('�![CDATA[', ']]�'), $sXml);	
	}
			
	private function _html($sData, $sType)
	{
		return str_replace('{:' . $sType . ':}', $sData, $this->_aStyle[$sType]);
	}
}

?>