<?php

class Shop{
	//                                       __  _          
	//     ____  _________  ____  ___  _____/ /_(_)__  _____
	//    / __ \/ ___/ __ \/ __ \/ _ \/ ___/ __/ / _ \/ ___/
	//   / /_/ / /  / /_/ / /_/ /  __/ /  / /_/ /  __(__  ) 
	//  / .___/_/   \____/ .___/\___/_/   \__/_/\___/____/  
	// /_/              /_/                                 
	public $view_all;
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct()
	{
		$this->_session_start();		
		$this->view_all = array(
			'filterFinish'  => 'All',
			'filterSize'    => 'All',
			'filterBrand'   => 'All',
			'filterSpecial' => 'All',
			'e&filterNew'   => 'All',
			'filterWeight'  => 'All');
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
		$_GET      = $this->getInit($_GET);
		$url       = sprintf('http://www.tirerack.com/wheels/WheelGridControlServlet?%s', http_build_query($_GET));		
		$dom       = new DOMDocument();
		$block_dom = new DOMDocument();		
		$html      = $this->fileGetContentsCurl($url);		
		// $html      = file_get_contents($url);	
		var_dump($url, $html);	
		$dom->loadHTML($html);
		$xpath     = new DOMXPath($dom);
		$blocks    = $xpath->query(".//*[@class='maincontainer']");
		$paging    = $xpath->query(".//*[@id='alloy']/table");
		$index     = 0;
		
		if(!$blocks->length) return null;
		$_SESSION['get'] = $_GET;

		$items['paging'] = $paging->item(0)->ownerDocument->saveHTML($paging->item(0));		
		$items['paging'] = str_replace('/wheels/WheelGridControlServlet', '/shop', $items['paging']);

		foreach ($blocks as $block) 
		{
			$block_dom->loadHTML($block->ownerDocument->saveHTML($block));
			$block_x         = new DOMXPath($block_dom);
			$wheel           = $block_x->query(".//*[@class='maincontainer']/div[1]/div[@class='imagelinks']/a/img");
			$logo            = $block_x->query(".//*[@class='maincontainer']/div[1]/p/a/img");
			$description     = $block_x->query(".//*[@class='maincontainer']/div[1]/h4/a");
			$cat_tabs        = $block_x->query(".//*[@class='maincontainer']/ul[@class='cat-tabs']");
			$wheel_info      = $block_x->query(".//*[@class='maincontainer']/div[@class='wheelInfo']");
			$view_on_vehicle = $block_x->query(".//*[@class='maincontainer']/div[@class='wheelInfo']/div[@class='btmBTNContainer']/div[@class='vovDetailLinks']/div[1]/a");
			$text            = $block_x->query(".//*[@class='maincontainer']/div[1]/h4");
			$paging          = $block_x->query(".//*[@id='alloy']/table");

			$text = $text->item(0)->ownerDocument->saveHTML($text->item(0));
			$text = preg_replace('/<a.*?<\/a>/', '', $text);
			$text = trim(str_replace(array('<br>', '<h4>', '</h4>'), '', $text));

			$items[] = array(
				'index'           => $index++,
				'wheel_img'       => $wheel->item(0)->getAttribute('src'),
				'logo_img'        => $logo->item(0)->getAttribute('src'),
				'cat_tabs_html'   => $cat_tabs->item(0)->ownerDocument->saveHTML($cat_tabs->item(0)),
				'wheel_info_html' => $wheel_info->item(0)->ownerDocument->saveHTML($wheel_info->item(0)),				
				'view_on_vehicle' => $view_on_vehicle->item(0)->getAttribute('href'),
				'text'			  => $text,
				'description'     => array(
					'href'      => $description->item(0)->getAttribute('href'),
					'value'     => $description->item(0)->nodeValue));			
		}

		return $items;
	}

	private function getInit($get)
	{
		if(!$get) return null;
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
				<ul class="links">
					<li><a href="#block-<?php echo $item['index']; ?>" class="bock-open">18" <br> 204</a></li>
					<li><a href="#block-<?php echo $item['index']; ?>" class="bock-open">20" <br> 249</a></li>
				</ul> 
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
		    <div class="header">
		    	<h1 style="float: left">Description</h1>
		        <a class="close" onclick="hideDialog(\'#block-<?php echo $id; ?>\')" data-dismiss="modal">×</a>
		    </div>
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
	public function fileGetContentsCurl($url) 
	{

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_COOKIE, 'WWW.TIRERACK.COM-172.16.1.16-443-COOKIE=R2653372670; JSESSIONID=06B54B36F9675C409F0A58DB54ED0E9B; Lock_Desktop=true');
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	    // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
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
}

// =========================================================
// LAUNCH
// =========================================================
$GLOBALS['shop'] = new Shop();