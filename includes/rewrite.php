<?php 

class Rewrite{
	//                          __              __      
	//   _________  ____  _____/ /_____ _____  / /______
	//  / ___/ __ \/ __ \/ ___/ __/ __ `/ __ \/ __/ ___/
	// / /__/ /_/ / / / (__  ) /_/ /_/ / / / / /_(__  ) 
	// \___/\____/_/ /_/____/\__/\__,_/_/ /_/\__/____/  
	const SITE_URL = 'http://www.tirerack.com/';	 

	//                                       __  _          
	//     ____  _________  ____  ___  _____/ /_(_)__  _____
	//    / __ \/ ___/ __ \/ __ \/ _ \/ ___/ __/ / _ \/ ___/
	//   / /_/ / /  / /_/ / /_/ /  __/ /  / /_/ /  __(__  ) 
	//  / .___/_/   \____/ .___/\___/_/   \__/_/\___/____/  
	// /_/              /_/                                 
	private $content_type;

	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct($args)
	{
		$url = self::SITE_URL.$_GET['s'];
		if(count($_GET) > 1)
		{
			unset($_GET['s']);
			$url.= '?'.http_build_query($_GET);
		}
		$img = $this->fileGetContentsCurl($url);
		header('Content-type: '.$this->content_type);
		echo $img;		

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
		
		$data               = curl_exec($ch);
		$this->content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
	    curl_close($ch);

	    return $data;
	}
}

// =========================================================
// LAUNCH
// =========================================================
$r = new Rewrite($_GET);