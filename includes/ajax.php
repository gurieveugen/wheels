<?php
// =========================================================
// REQUIRE
// =========================================================
require($_SERVER["DOCUMENT_ROOT"].'/wp-blog-header.php');
require_once 'shop.php';
require_once 'view_on_vehicle.php';
require_once 'change_vehicle_color.php';
require_once 'single_tire.php';

header("HTTP/1.1 200 OK");


class AJAX{
	//                          __              __      
	//   _________  ____  _____/ /_____ _____  / /______
	//  / ___/ __ \/ __ \/ ___/ __/ __ `/ __ \/ __/ ___/
	// / /__/ /_/ / / / (__  ) /_/ /_/ / / / / /_(__  ) 
	// \___/\____/_/ /_/____/\__/\__,_/_/ /_/\__/____/  
	const PARSE_SITE   = 'http://www.tirerack.com/survey/ValidationServlet';
	const RESULTS_URL  = 'http://www.tirerack.com/wheels/results.jsp';
	const TIRES_FILTER = 'http://www.tirerack.com/tires/TireSearchControlServlet';
	const SITE         = 'http://www.tirerack.com';

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
	 * Get short code from post request
	 */
	public function getShortCode()
	{
		echo do_shortcode(stripslashes($_POST['short_code']));
	}

	/**
	 * Get tire additional info
	 */
	public function loadSingleTire()
	{
		$single_tire = new SingleTire($_POST);		
		echo json_encode($single_tire->parse());
	}

	/**
	 * Change Vehicle car color
	 */
	public function changeVehicleColor()
	{
		$change_vehicle_color = new ChangeVehicleColor($_POST);		
		echo $change_vehicle_color->parse();
	}

	/**
	 * Parser "view on vehicle" 
	 */
	public function viewOnVehicle()
	{
		$view_on_vehicle = new ViewOnVehicle($_POST);
		$json = $view_on_vehicle->parse();
		echo json_encode($json);
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
	 * Filter Tires
	 */
	public function getTireLocations()
	{
		$query = array(
			'ajax'         => 'true',
			'action'       => 'filterTires',
			'startIndex'   => '0',
			'viewPerPage'  => '10',
			'brands'       => isset($_POST['brands']) && is_array($_POST['brands']) ? implode(',', $_POST['brands']) : '',
			'perfCats'     => isset($_POST['perfCats']) && is_array($_POST['perfCats']) ? implode(',', $_POST['perfCats']) : '',
			'speedRatings' => isset($_POST['speedRatings']) && is_array($_POST['speedRatings']) ? implode('%2C', $_POST['speedRatings']) : '',
			'loadRatings'  => 'S,RF,XL,C,D,E,F,G',
			'RunFlat'      => $_POST['RunFlat'],
			'LRR'          => $_POST['LRR'],
			'priceFilter'  => $_POST['priceFilter']
		);
		$url = self::TIRES_FILTER.'?'.$this->joinArray($query);
		$cookie = $GLOBALS['shop_page']->getCookieSession($_POST);		
		echo $GLOBALS['shop_page']->fileGetContentsCurl($url, $cookie, false);		
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
}

// =========================================================
// LAUNCH
// =========================================================
$GLOBALS['AJAX'] = new AJAX($_GET['action']);