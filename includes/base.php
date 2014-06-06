<?php 
/**
 * Helper class 
 */
class Base{
	//                          __              __      
	//   _________  ____  _____/ /_____ _____  / /______
	//  / ___/ __ \/ __ \/ ___/ __/ __ `/ __ \/ __/ ___/
	// / /__/ /_/ / / / (__  ) /_/ /_/ / / / / /_(__  ) 
	// \___/\____/_/ /_/____/\__/\__,_/_/ /_/\__/____/  
	const SESSION_URL         = 'http://www.tirerack.com/wheels/results.jsp?%s';
	const WHEELS_URL          = 'http://www.tirerack.com/wheels/WheelGridControlServlet?%s';
	const TIRES_IN_DETAIL_URL = 'http://www.tirerack.com/tires/TireSearchResults.jsp?%s';
	const CACHE_ON            = TRUE;
	//                                       __  _          
	//     ____  _________  ____  ___  _____/ /_(_)__  _____
	//    / __ \/ ___/ __ \/ __ \/ _ \/ ___/ __/ / _ \/ ___/
	//   / /_/ / /  / /_/ / /_/ /  __/ /  / /_/ /  __(__  ) 
	//  / .___/_/   \____/ .___/\___/_/   \__/_/\___/____/  
	// /_/              /_/                                 
	public $request;
	public $request_http;
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct($request)
	{
		$this->_session_start();
		$this->request       = $request;
		$this->request_http  = $request != null ? http_build_query($this->request) : null;	
	}

	/**
	 * Get contents 
	 * @param  string $url
	 * @return string
	 */
	public function fileGetContentsCurl($url, $cookie = '', $header = true) 
	{
		
	    $ch = curl_init();    
	    
	    curl_setopt($ch, CURLOPT_HEADER, $header);
	    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
	   	if($cookie != '')
	   	{
	   		$head = array('Cookie: '.$cookie);
	   		curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
	   	} 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($ch, CURLOPT_URL, $url);

	    $data = curl_exec($ch);	   
	    curl_close($ch);

	    return $data;
	}

	/**
	 * Join array to string
	 * @param  array $arr --- array to join
	 * @return string     --- converted string
	 */
	public function joinArray($arr)
	{
		if(!$arr) return '';
		$paramsJoined = array();
		foreach($arr as $param => $value) 
		{
		   $paramsJoined[] = "$param=$value";
		}

		return implode('&', $paramsJoined);
	}

	/**
	 * Start session if not started
	 * @return boolean --- TRUE if started new session | FALSE if not
	 */
	public function _session_start()
	{
		if(session_id() == '')
		{
			session_start();
			return true;	
		} 
		return false;
	}

	/**
	 * Set Cache
	 * @param string  $key    
	 * @param string  $val    
	 * @param integer $time   
	 * @param string  $prefix 
	 */
	public function setCache($key, $val, $time = 3600, $prefix = 'cheched-')
	{		
		set_transient($prefix.$key, $val, $time);
	}

	/**
	 * Get Cache
	 * @param  string $key    
	 * @param  string $prefix 
	 * @return mixed
	 */
	public function getCache($key, $prefix = 'cheched-')
	{		
		if(self::CACHE_ON)
		{
			$cached   = get_transient($prefix.$key);
			if (false !== $cached) return $cached;	
		}
		return false;
	}

	/**
	 * Template part to string val
	 * @param  string $template_name 
	 * @param  string $part_name     
	 * @return string                
	 */
	public function loadTemplatePart($template_name, $part_name = null) 
	{
		ob_start();
		get_template_part($template_name, $part_name);
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}

	/**
	 * Get select control
	 * @param  string $name    --- control name
	 * @param  array  $values  --- options array
	 * @param  string $prepend --- prepend options
	 * @return string          --- html code select control
	 */
	public function getSelectControl($name, $values, $current = '', $preped = '')	
	{
		$options = $preped;
		if(is_array($values))
		{
			foreach ($values as &$val) 
			{
				$options.= sprintf('<option value="%1$s" %2$s>%1$s</option>', $val, $this->selected($val == $current));
			}
		}
		return sprintf('<select name="%1$s" id="%1$s">%2$s</select>', $name, $options);
	}		

	/**
	 * Helper class for select control
	 * @param  boolean $yes --- return select or empty string
	 * @return string 		--- select | empty string
	 */
	public function selected($yes)
	{
		return $yes ? 'selected' : '';
	}

	/**
	 * Get attribute from DOMElement
	 * @param  object $item --- item
	 * @param  string $name --- attribute name
	 * @return string       --- empty if is not DOMElement | return attribute if success
	 */
	protected function getAttribute($item, $name = 'src')
	{
		if(get_class($item->item(0)) != 'DOMElement') return '';
		return $item->item(0)->getAttribute($name);
	}


	/**
	 * Convert page parameter to _page.
	 * Needed for normal work wordpress.
	 * @param  string $str --- query
	 * @return string      --- converted query
	 */
	protected function pageTo_Page($str)
	{
		return str_replace('page&amp;page', 'page&amp;_page', $str);
	}

	/**
	 * Convert _page parameter to page.
	 * Needed for normal work wordpress.
	 * @param  array $get --- request
	 * @return array      --- converted query reques
	 */
	protected function _pageToPage($request)
	{
		if(isset($request['_page']))
		{
			$request['page'] = $request['_page'];
			unset($request['_page']);	
		} 
		return $request;
	}

	/**
	 * Transform array to input hide variables
	 * Example:
	 * array('key1' => 'value1', 'ke2' => 'value2');
	 * TO
	 * <input type="hidden" name="key1" value="value1">
	 * <input type="hidden" name="key2" value="value12>	 * 
	 * @param  array $arr --- fields and values
	 * @return string     --- hidden inputs
	 */
	public function arrayToHideInputs($arr, $type = '')
	{
		$out = '';
		if($arr)
		{			
			foreach ($arr as $key => $value) 
			{
				$out.= sprintf('<input type="hidden" name="%s" value="%s">', $key, $value);
			}

			$out.= $type != '' ? sprintf('<input type="hidden" name="r1" value="%s">', $type) : '';
		}
		return $out;
	}

	/**
	 * Check now filtering?
	 * @param  array  $request --- request
	 * @return boolean         --- if filtering return TRUE | if not filtering FALSE
	 */
	public function isFiltering($request, $filter_fields)
	{		
		foreach ($filter_fields as &$value) 
		{
			if(isset($request[$value]))
			{
				if($request[$value] != 'All') return true;
			}
		}
		return false;
	}

	/**
	 * Build query for reset filter button
	 * @param  array $get --- request
	 * @return string     --- query
	 */
	public function getResetQuery($filter_fields, $get)
	{
		foreach ($filter_fields as &$value) 
		{
			$get[$value] = 'All';
		}
		$get['r1'] = $this->type;
		return http_build_query($get);
	}

	/**
	 * Get cookies for auth session
	 * @return string --- Coolies. Example: param1=value1; param2=value2
	 */
	public function getCookieSession()
	{
		$cookie = $this->getCache('cookie');
		if($cookie) return $cookie;

		$url  = sprintf(self::SESSION_URL, http_build_query($this->request));
		$html = $this->fileGetContentsCurl($url);
		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $html, $m);	
		$cookie = $m[1][0].'; '.$m[1][1];

		$this->setCache('cookie', $cookie);
		return $cookie;
	} 
}