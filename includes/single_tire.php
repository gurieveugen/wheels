<?php
require_once 'base.php';
class SingleTire extends Base{
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
		$items  = array();
		$dom    = new DOMDocument();
		$cookie = $this->getCookieSession();	
		$url    = self::SITE.$this->request['url'];
		$html   = $this->fileGetContentsCurl($url, $cookie, false);
		$dom->loadHTML($html);
		
		$xpath          = new DOMXPath($dom);
		$images         = $xpath->query(".//*[@id='thumbs']/a");
		$description    = $xpath->query(".//*[@id='tr_tab_content_1']/div[@id='englishCopy']");
		$surveys        = $xpath->query(".//*[@id='tr_tab_content_5']");
		
		$images         = $this->getImages($images);
		$description    = $description->item(0)->ownerDocument->saveHTML($description->item(0));	
		$surveys        = $surveys->item(0)->ownerDocument->saveHTML($surveys->item(0));	
		$surveys_remove = array(
			'<img src="/images/tires/TR_CSR.jpg" alt="Consumer Survey Recommended">', 
			'<a href="/tires/surveyresults/surveydisplay.jsp?type=MP"> See a Full List of Survey Results for Max Performance Summer Tires</a>',
			'<a href="/tires/surveyresults/index.jsp">online tire survey</a>',
			'style="display:none"');
		$surveys        = str_replace($surveys_remove, '', $surveys);

		
		$items = array(
			'images'      => $images,
			'description' => $description,
			'surveys'     => $surveys);
		
		return $items;
	}

	/**
	 * Get imaes from page
	 * @param  DOMNodeList $list --- images
	 * @return array             --- images array
	 */
	public function getImages($list)
	{
		$imgs = array();
		if($list->length)
		{
			foreach ($list as $image) 
			{
				$large = $image->getAttribute('onclick');				
				$small = $image->getElementsByTagName('img');

				if(preg_match('/\/.*\'/', $large, $large_matches))
				{
					$large = str_replace('\'', '', $large_matches[0]);
				}

				$small = $small->item(0)->getAttribute('src');

				$imgs[] = array(
					'large' => $large,
					'small' => $small);
			}
		}
		return $imgs;
	}
}