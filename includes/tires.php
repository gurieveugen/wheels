<?php

class Tires extends base{
	//                          __              __      
	//   _________  ____  _____/ /_____ _____  / /______
	//  / ___/ __ \/ __ \/ ___/ __/ __ `/ __ \/ __/ ___/
	// / /__/ /_/ / / / (__  ) /_/ /_/ / / / / /_(__  ) 
	// \___/\____/_/ /_/____/\__/\__,_/_/ /_/\__/____/  
	const SIZES_URL = 'http://www.tirerack.com/tires/SelectTireSize.jsp?';	                                                
	//                                       __  _          
	//     ____  _________  ____  ___  _____/ /_(_)__  _____
	//    / __ \/ ___/ __ \/ __ \/ _ \/ ___/ __/ / _ \/ ___/
	//   / /_/ / /  / /_/ / /_/ /  __/ /  / /_/ /  __(__  ) 
	//  / .___/_/   \____/ .___/\___/_/   \__/_/\___/____/  
	// /_/              /_/                                 

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
		$dom       = new DOMDocument();
		$tr_dom    = new DOMDocument();	
		$url       = self::SIZES_URL.$this->request_http;
		$html      = $this->fileGetContentsCurl($url, '', false);		
		$old_link  = '';
		$dom->loadHTML($html);
		$xpath = new DOMXPath($dom);

		
		$trs = $xpath->query(".//table/tr[2]//div/table/tr[not(@bgcolor)]");		
		if(!$trs->length) return null;

		foreach ($trs as $tr) 
		{
			$tr_dom->loadHTML($tr->ownerDocument->saveHTML($tr));	
			$tr_x = new DOMXPath($tr_dom);
			$description = $tr_x->query(".//td[1]/b");
			$size        = $tr_x->query(".//td[2]/b");
			$a           = $tr_x->query("//a[contains(@href,'tab=All')]");
			$link        = $this->getAttribute($a, 'href');

			if($link != '')
			{
				$link = explode('?', $link);			
				$link = '?'.$link[1].'&r1=tires_in_detail';
			}
			else
			{
				$link = $old_link;
			}

			$old_link    = $link;
			$items[] = array(
				'a' => $link,
				'size' => $size->item(0)->nodeValue,
				'description' => $description->item(0)->nodeValue);
		}
		
		return $items;
	}

	/**
	 * Wrap all items
	 * @param  array $items --- parsed items
	 * @return string       --- html code
	 */
	public function wrapItems($items)
	{
		if(!$items) return $this->loadTemplatePart('notfound');
		$out = '';
		foreach ($items as &$item) 
		{
			$out.= $this->wrapItem($item);
		}
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
		<tr>
			<td><b><?php echo $item['description']; ?></b></td>
			<td><b><?php echo $item['size']; ?></b></td>
			<td><a href="<?php echo $item['a']; ?>" alt="View all matching">View all matching</a></td>	
		</tr>
		<?php
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}

	/**
	 * Get table head
	 * @return string --- html code
	 */
	public function getTableHead()
	{
		ob_start();
		?>
		<thead>
			<tr>
				<th>Description</th>
				<th>Size</th>
				<th>Button</th>
			</tr>
		</thead>
		<?php
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}

	/**
	 * Get Filter sidebar
	 * @return string
	 */
	public function getFilterSidebar($items)
	{
		return '';
	}

	public function getPagination()
	{
		return '';
	}
}