<?php
require_once 'base.php';
class ViewOnVehicle extends Base{
	//                          __              __      
	//   _________  ____  _____/ /_____ _____  / /______
	//  / ___/ __ \/ __ \/ ___/ __/ __ `/ __ \/ __/ ___/
	// / /__/ /_/ / / / (__  ) /_/ /_/ / / / / /_(__  ) 
	// \___/\____/_/ /_/____/\__/\__,_/_/ /_/\__/____/  
	const SITE = 'http://www.tirerack.com';
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct($request)
	{
		parent::__construct($request);		
	}

	/**
	 * Parse site
	 * @return array --- parsed items
	 */
	public function parse()
	{
		libxml_use_internal_errors(true);
		$dom    = new DOMDocument();
		$cookie = $this->getCookieSession();	
		$url    = self::SITE.$this->request['url'].'&size=0';
		$html   = $this->fileGetContentsCurl($url, $cookie, false);
		$dom->loadHTML($html);
		$xpath  = new DOMXPath($dom);

		$car_obj         = $xpath->query(".//*[@id='WSLvehicleImage']");
		$wheel_obj       = $xpath->query(".//*[@id='WSLrearWheelImg']");
		$title_obj       = $xpath->query(".//*[@id='WSLcar']");
		$description_obj = $xpath->query(".//*[@id='WSLspecs']");
		$select_obj      = $xpath->query(".//*[@id='WSLchangeColor']");

		// =========================================================
		// PARSE CAR
		// =========================================================
		$car = $this->getAttribute($car_obj);

		// =========================================================
		// PARSE WHEEL
		// =========================================================
		$wheel = $this->getAttribute($wheel_obj);

		// =========================================================
		// PARSE TITLE
		// =========================================================
		$title = $title_obj->item(0)->ownerDocument->saveHTML($title_obj->item(0));
		$title = explode('<br>', $title);
		$title = str_replace('<div id="WSLcar">', '', $title[0]);

		// =========================================================
		// PARSE SELECT
		// =========================================================
		$select = $select_obj->item(0)->ownerDocument->saveHTML($select_obj->item(0));

		// =========================================================
		// PARSE DESCRIPTION
		// =========================================================		
		$description = $description_obj->item(0)->ownerDocument->saveHTML($description_obj->item(0));
		if(preg_match('/(?s)<td align="right" id="WSLlinks".*?<\/td>/', $description, $description_matches))
		{
			$description = str_replace($description_matches[0], '', $description);
		}
		if(preg_match('/<a.*?>/', $description, $description_matches))
		{
			$description = str_replace($description_matches[0], '', $description);
		}
		$description = str_replace('</a>', '', $description);

		$vars = $this->getJavaVars($html, array('smallFrontY', 'smallFrontX', 'smallRearY', 'smallRearX'));		

		$items = array(
			'car'         => $car,
			'title'       => $title,
			'wheel'       => $wheel,
			'select'      => $select,
			'description' => $description);
		$items = array_merge($vars, $items);
		
		return $items;
	}

	/**
	 * Get JAVA vars from html
	 * @param  string $html --- html code
	 * @param  array $vars  --- needed vars to get
	 * @return array        --- result array
	 */
	public function getJavaVars($html, $vars)
	{
		$res = array();
		foreach ($vars as $var) 
		{
			if(preg_match('/var '.$var.' = "[0-9]*/', $html, $matches))
			{
				$res[$var] = str_replace('var '.$var.' = "', '', $matches[0]);				
			}
		}
		return $res;
	}
}