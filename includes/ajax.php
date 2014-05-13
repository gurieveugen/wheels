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

		foreach ($blocks as $block) 
		{
			$block_dom->loadHTML($block->ownerDocument->saveHTML($block));
			$block_x     = new DOMXPath($block_dom);
			$wheel       = $block_x->query(".//*[@class='maincontainer']/div[1]/div[@class='imagelinks']/a/img");
			$logo        = $block_x->query(".//*[@class='maincontainer']/div[1]/p/a/img");
			$description = $block_x->query(".//*[@class='maincontainer']/div[1]/h4/a");
			$cat_tabs    = $block_x->query(".//*[@class='maincontainer']/ul[@class='cat-tabs']");
			$wheel_info  = $block_x->query(".//*[@class='maincontainer']/div[@class='wheelInfo']");

			$items[] = array(
				'wheel_img'       => $wheel->item(0)->getAttribute('src'),
				'logo_img'        => $logo->item(0)->getAttribute('src'),
				'cat_tabs_html'   => $cat_tabs->item(0)->ownerDocument->saveHTML($cat_tabs->item(0)),
				'wheel_info_html' => $cat_tabs->item(0)->ownerDocument->saveHTML($cat_tabs->item(0)),
				'description'     => array(
					'href'      => $description->item(0)->getAttribute('href'),
					'value'     => $description->item(0)->nodeValue));
		}


		// $x_logos_img  = $xpath->query(".//*[@class='maincontainer']/div[1]/p/a/img");
		// $x_urls       = $xpath->query(".//*[@class='maincontainer']/div[1]/h4/a");
		
		// for ($i=0; $i < $x_wheels_img->length; $i++) 
		// { 
		// 	$items[] = array(
		// 		'wheel_img' => $x_wheels_img->item($i)->getAttribute('src'),
		// 		'logo_img'  => $x_logos_img->item($i)->getAttribute('src'),
		// 		'href'      => $x_urls->item($i)->getAttribute('href'),
		// 		'value'     => $x_urls->item($i)->nodeValue);
		// 	var_dump($x_wheels_img->item($i)->ownerDocument->saveHTML($x_wheels_img->item($i)));
		// }
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