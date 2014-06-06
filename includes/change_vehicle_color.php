<?php
require_once 'base.php';
class ChangeVehicleColor extends Base{
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
		$cookie = $this->getCookieSession();	
		$url    = self::SITE.$this->request['url'];
		$html   = $this->fileGetContentsCurl($url, $cookie, false);		
		
		return $html;
	}
}