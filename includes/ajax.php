<?php
// =========================================================
// REQUIRE
// =========================================================
require($_SERVER["DOCUMENT_ROOT"].'/wp-blog-header.php');
header("HTTP/1.1 200 OK");


class AJAX{
	//                          __              __      
	//   _________  ____  _____/ /_____ _____  / /______
	//  / ___/ __ \/ __ \/ ___/ __/ __ `/ __ \/ __/ ___/
	// / /__/ /_/ / / / (__  ) /_/ /_/ / / / / /_(__  ) 
	// \___/\____/_/ /_/____/\__/\__,_/_/ /_/\__/____/  
	const PARSE_SITE  = 'http://www.tirerack.com/survey/ValidationServlet';
	const RESULTS_URL = 'http://www.tirerack.com/wheels/results.jsp';
	const SITE        = 'http://www.tirerack.com';

	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct($action)
	{			
		if(method_exists($this, $action))
		{
			$this->$action();
		}		
	}

	/**
	 * Get info block. AJAX.
	 */
	public function getInfo()
	{
		$url    = str_replace('/wheels/WheelGridControlServlet?', '', $_GET['url']);
		$url    = sprintf($GLOBALS['shop_page']::WHEELS_URL, $url);
		$cookie = $GLOBALS['shop_page']->getCookieSession();
		$xml    = $GLOBALS['shop_page']->fileGetContentsCurl($url, $cookie, false);		
		echo $xml;
	}

	/**
	 * GET years XML
	 * @return string --- XML CODE
	 */
	public function getYears()
	{
		$this->displayXML(sprintf(self::PARSE_SITE.'?autoMake=%s&autoYearsNeeded=true', $_POST['automake']));
	}

	/**
	 * GET models XML
	 * @return string --- XML CODE
	 */
	public function getModels()
	{
		$this->displayXML(sprintf(self::PARSE_SITE.'?autoYear=%s&autoMake=%s', $_POST['autoyear'], $_POST['automake']));
	}

	/**
	 * Get Additional car info
	 * @return string --- XML CODE
	 */
	public function getAdditionalInfo()
	{
		$this->displayXML(sprintf(self::PARSE_SITE.'?autoYear=%s&autoMake=%s&autoModel=%s', $_POST['autoyear'], $_POST['automake'], $_POST['automodel']));
	}

	/**
	 * Get results
	 * @return string --- XML CODE
	 */
	public function getResults()
	{
		$dom       = new DOMDocument();
		$block_dom = new DOMDocument();
		$html      = $this->fileGetContentsCurl('http://www.tirerack.com/wheels/results.jsp?autoMake=BMW&autoModel=328i+Cabriolet&autoYear=2010&autoModClar=Base+Model');
		$dom->loadHTML($html);
		$xpath     = new DOMXPath($dom);
		$blocks    = $xpath->query(".//*[@class='maincontainer']");
		$index     = 0;

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
		echo json_encode($items);
	}

	/**
	 * Get and Display XML request
	 * @param  string $url --- Link to XML
	 * @return XML CODE ( STRING )
	 */
	private function displayXML($url)
	{
		$XML = $this->fileGetContentsCurl($url);
		echo $XML;
	}

	/**
	 * Get contents 
	 * @param  string $url
	 * @return string
	 */
	public function fileGetContentsCurl($url) 
	{
	    $ch = curl_init();

	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	    curl_setopt($ch, CURLOPT_URL, $url);

	    $data = curl_exec($ch);
	    curl_close($ch);

	    return $data;
	}
}

// =========================================================
// LAUNCH
// =========================================================
$GLOBALS['AJAX'] = new AJAX($_GET['action']);