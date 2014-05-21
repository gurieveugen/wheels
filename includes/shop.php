<?php

class Shop{
	//                          __              __      
	//   _________  ____  _____/ /_____ _____  / /______
	//  / ___/ __ \/ __ \/ ___/ __/ __ `/ __ \/ __/ ___/
	// / /__/ /_/ / / / (__  ) /_/ /_/ / / / / /_(__  ) 
	// \___/\____/_/ /_/____/\__/\__,_/_/ /_/\__/____/  
	const SESSION_URL = 'http://www.tirerack.com/wheels/results.jsp?%s';
	const WHEELS_URL  = 'http://www.tirerack.com/wheels/WheelGridControlServlet?%s';
	const CACHE_ON    = TRUE;
	//                                       __  _          
	//     ____  _________  ____  ___  _____/ /_(_)__  _____
	//    / __ \/ ___/ __ \/ __ \/ _ \/ ___/ __/ / _ \/ ___/
	//   / /_/ / /  / /_/ / /_/ /  __/ /  / /_/ /  __(__  ) 
	//  / .___/_/   \____/ .___/\___/_/   \__/_/\___/____/  
	// /_/              /_/                                 
	public $view_all;
	public $filter_fields;
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct()
	{
		$this->_session_start();	
		$this->filter_fields = array(
			'filterSize',
			'filterFinish',
			'filterBrand',
			'filterWeight',
			'filterNew');;	
	}

	/**
	 * Get results
	 * @return string --- XML CODE
	 */
	public function getResults()
	{
		if(!$_GET) return null;		
		libxml_use_internal_errors(true);
		unset($_GET['r1']);
		$cookie    = $this->getCookieSession();
		$_GET      = $this->getInit($_GET);		
		$_GET      = $this->_pageToPage($_GET);		
		$url       = $this->isFiltering($_GET) ? sprintf(self::SESSION_URL, http_build_query($_GET)) : sprintf(self::WHEELS_URL, http_build_query($_GET));
		$dom       = new DOMDocument();
		$block_dom = new DOMDocument();				
		$html      = $this->fileGetContentsCurl($url, $cookie, false);		
		$dom->loadHTML($html);
		
		$xpath         = new DOMXPath($dom);
		$blocks        = $xpath->query(".//*[@id='alloy']/div/div[@class='maincontainer']");
		$paging        = $xpath->query(".//*[@id='alloy']/table");
		$filter_size   = $xpath->query(".//*[@id='filterSize_id']");
		$filter_finish = $xpath->query(".//*[@id='filterFinish_id']");
		$filter_brand  = $xpath->query(".//*[@id='filterBrand_id']");
		$filter_weight = $xpath->query(".//*[@id='filterWeight_id']");
		$index     = 0;
		
		if(!$blocks->length) return null;
		$_SESSION['get'] = $_GET;

		$items['paging'] = $paging->item(0)->ownerDocument->saveHTML($paging->item(0));		
		$items['paging'] = str_replace('/wheels/WheelGridControlServlet', '/shop', $items['paging']);
		$items['paging'] = preg_replace('/<table.*?>/', '<table width="100%" cellspacing="0" cellpadding="0" class="paging-table">', $items['paging']);
		$items['paging'] = str_replace('<td align="right">', '<td class="text-right numbers">', $items['paging']);
		$items['paging'] = $this->pageTo_Page($items['paging']);

		$items['filter_size']   = $filter_size->item(0)->ownerDocument->saveHTML($filter_size->item(0));
		$items['filter_finish'] = $filter_finish->item(0)->ownerDocument->saveHTML($filter_finish->item(0));
		$items['filter_brand']  = $filter_brand->item(0)->ownerDocument->saveHTML($filter_brand->item(0));
		$items['filter_weight'] = $filter_weight->item(0)->ownerDocument->saveHTML($filter_weight->item(0));

		foreach ($blocks as $block) 
		{
			$block_dom->loadHTML($block->ownerDocument->saveHTML($block));			
			$block_x         = new DOMXPath($block_dom);
			$wheel           = $block_x->query(".//*[@class='maincontainer']/div[1]/div[@class='imagelinks']/a/img");			
			$logo            = $block_x->query(".//*[@class='maincontainer']/div[1]/p/a/img");
			$description     = $block_x->query(".//*[@class='maincontainer']/div[1]/h4/a");
			$cat_tabs        = $block_x->query(".//*[@class='maincontainer']/ul[@class='cat-tabs']");
			$wheel_info      = $block_x->query(".//*[@class='maincontainer']/div[@class='wheelInfo']");
			$wheel_info_btn  = $block_x->query(".//*[@class='maincontainer']/div[@class='wheelInfo']/div[@class='btmBTNContainer']");
			$view_on_vehicle = $block_x->query(".//*[@class='maincontainer']/div[@class='wheelInfo']/div[@class='btmBTNContainer']/div[@class='vovDetailLinks']/div[1]/a");
			$text            = $block_x->query(".//*[@class='maincontainer']/div[1]/h4");

			$text = $text->item(0)->ownerDocument->saveHTML($text->item(0));
			$text = preg_replace('/<a.*?<\/a>/', '', $text);
			$text = trim(str_replace(array('<br>', '<h4>', '</h4>'), '', $text));


			$wheel_info_str     = $wheel_info->item(0)->ownerDocument->saveHTML($wheel_info->item(0));
			$wheel_info_btn_str = $wheel_info_btn->item(0)->ownerDocument->saveHTML($wheel_info_btn->item(0));
			$wheel_info_str     = str_replace($wheel_info_btn_str, '', $wheel_info_str);

			$items[] = array(
				'index'           => $index++,
				'wheel_img'       => $this->getAttribute($wheel),
				'logo_img'        => $this->getAttribute($logo),
				'cat_tabs_html'   => $cat_tabs->item(0)->ownerDocument->saveHTML($cat_tabs->item(0)),
				'wheel_info_html' => $wheel_info_str,				
				'view_on_vehicle' => $this->getAttribute($view_on_vehicle, 'href'),
				'text'			  => $text,
				'description'     => array(
					'href'      => $this->getAttribute($description, 'href'),
					'value'     => $description->item(0)->nodeValue));			
		}

		return $items;
	}

	/**
	 * Build query for reset filter button
	 * @param  array $get --- request
	 * @return string     --- query
	 */
	public function getResetQuery($get)
	{
		foreach ($this->filter_fields as &$value) 
		{
			$get[$value] = 'All';
		}
		return http_build_query($get);
	}

	/**
	 * Check now filtering?
	 * @param  array  $get --- request
	 * @return boolean     --- if filtering return TRUE | if not filtering FALSE
	 */
	public function isFiltering($get)
	{		
		foreach ($this->filter_fields as &$value) 
		{
			if(isset($get[$value]))
			{
				if($get[$value] != 'All') return true;
			}
		}
		return false;
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
	public function arrayToHideInputs($arr)
	{
		$out = '';
		if($arr)
		{
			foreach ($arr as $key => $value) 
			{
				$out.= sprintf('<input type="hidden" name="%s" value="%s">', $key, $value);
			}
		}
		return $out;
	}

	/**
	 * Convert page parameter to _page.
	 * Needed for normal work wordpress.
	 * @param  string $str --- query
	 * @return string      --- converted query
	 */
	private function pageTo_Page($str)
	{
		return str_replace('page&amp;page', 'page&amp;_page', $str);
	}

	/**
	 * Convert _page parameter to page.
	 * Needed for normal work wordpress.
	 * @param  array $get --- request
	 * @return array      --- converted query reques
	 */
	private function _pageToPage($get)
	{
		if(isset($get['_page']))
		{
			$get['page'] = $get['_page'];
			unset($get['_page']);	
		} 
		return $get;
	}

	/**
	 * Get attribute from DOMElement
	 * @param  object $item --- item
	 * @param  string $name --- attribute name
	 * @return string       --- empty if is not DOMElement | return attribute if success
	 */
	private function getAttribute($item, $name = 'src')
	{
		if(get_class($item->item(0)) != 'DOMElement') return '';
		return $item->item(0)->getAttribute($name);
	}

	/**
	 * Get cookies for auth session
	 * @return string --- Coolies. Example: param1=value1; param2=value2
	 */
	public function getCookieSession()
	{
		$cookie = $this->getCache('cookie');
		if($cookie) return $cookie;
		$url  = sprintf(self::SESSION_URL, http_build_query($_GET));
		$html = $this->fileGetContentsCurl($url);
		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $html, $m);	
		$cookie = $m[1][0].'; '.$m[1][1];
		$this->setCache('cookie', $cookie);
		return $cookie;
	}

	/**
	 * Init response GET
	 * @param  array $get --- $_GET
	 * @return array      --- initialized get
	 */
	private function getInit($get)
	{
		if(!$get) return null;
		$tmp 		     = null;
		$compress_fields = array('autoMake', 'autoYear', 'autoModel', 'autoModClar');
		foreach ($compress_fields as $field) 
		{
			if(isset($get[$field]))
			{
				$tmp[$field] = $get[$field];				
			}
		}
		
		$get['qs'] = $this->joinArray($tmp);
		return $get;
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
	 * Wrap all items
	 * @param  array $items --- items array
	 * @return string       --- HTML code
	 */
	public function wrapItems($items)
	{
		if(!$items) return $this->loadTemplatePart('notfound');

		$out = '';
		for ($i=0; $i < count($items); $i+=2) 
		{ 
			$out.= '<tr>';
			for ($j=0; $j < 2; $j++) 
			{ 
				if(isset($items[$i+$j])) $out.= $this->wrapItem($items[$i+$j]);
			}
			$out.= '</tr>';
			
		}
		$out.= sprintf('<tr>%s</tr>', $items['paging']);
		return $out;
	}

	/**
	 * Wrap one result item
	 * @param  array $item --- one item
	 * @return string      --- HTML code
	 */
	public function wrapItem($item)
	{
		ob_start();
		?>
		<td>
			<div class="left-side">
				<div class="image">
					<img src="<?php echo $item['wheel_img']; ?>" alt="">
				</div>
				<?php echo $item['cat_tabs_html']; ?>
			</div>
			<div class="right-side">
				<div class="image">
					<a href="#"><img src="<?php echo $item['logo_img']; ?>" alt=""></a>
				</div>
				<?php echo $item['description']['value']; ?><br><br>
				<span class="description">
					<?php echo $item['text']; ?>
				</span><br>
				<a href="<?php echo $item['view_on_vehicle']; ?>" class="link view-on-vehicle" onclick="popUp(this); return false;" target="_blank"><b>View on Vehicle</b></a>
			</div>
			<?php echo $this->wrapItemInfo($item['index'], $item['wheel_info_html']); ?>
		</td>
		<?php
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}

	/**
	 * Wrap item info blcok
	 * @param  integer $id  --- item id
	 * @param  string $text --- HTML code
	 * @return string       --- HTML code
	 */
	public function wrapItemInfo($id, $text)
	{
		ob_start();
		?>
		<div style="display: none" class="modal" id="block-<?php echo $id; ?>">		    
		    <div class="body text-center">			        
		        <?php echo $text; ?>
		   	</div>
		    <div class="footer">
		    	<a href="#" data-dismiss="modal" onclick="hideDialog(\'#block-<?php echo $id; ?>\')" class="btn btn-shop btn-success right">Hide description</a>
		    </div>
		</div>
		<?php
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
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
	 * @param  string $name   --- control name
	 * @param  array  $values --- options array
	 * @return string         --- html code select control
	 */
	public function getSelectControl($name, $values)	
	{
		$options = '';
		if(is_array($values))
		{
			foreach ($values as &$val) 
			{
				if(strpos($val, 'Select')-1) $options.= sprintf('<option value="">%s</option>', $val);
				else $options.= sprintf('<option value="%s">%s</option>', $val, $val);
			}
		}
		return sprintf('<select name="%s" id="%s">%s</select>', $name, $name, $options);
	}

	/**
	 * Get revers years array
	 * @param  integer $limit --- how much year we return
	 * @return array          --- revers years. Example: 2014, 2013, 2012 ...
	 */
	public function getReversYears($limit = 100)
	{
		$y = date('Y');
		for ($i=$y; $i > ($y - $limit); $i--) 
		{ 
			$arr[] = $i;
		}
		return $arr;
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
}

// =========================================================
// LAUNCH
// =========================================================
$GLOBALS['shop'] = new Shop();