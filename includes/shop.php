<?php
require_once 'base.php';
require_once 'wheels.php';
require_once 'tires.php';
require_once 'tires_in_detail.php';

class Shop extends Base{	
	//                                       __  _          
	//     ____  _________  ____  ___  _____/ /_(_)__  _____
	//    / __ \/ ___/ __ \/ __ \/ _ \/ ___/ __/ / _ \/ ___/
	//   / /_/ / /  / /_/ / /_/ /  __/ /  / /_/ /  __(__  ) 
	//  / .___/_/   \____/ .___/\___/_/   \__/_/\___/____/  
	// /_/              /_/                                 
	public $view_all;
	public $filter_fields;
	public $type; 
	public $parsers; 
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct()
	{			
		parent::__construct(NULL);	
	}

	/**
	 * Get results
	 * @return string --- XML CODE
	 */
	public function getResults()
	{		
		unset($_GET['q']);
		$this->type       = isset($_SESSION['type']) ? $_SESSION['type'] : 'wheels';
		$this->type       = isset($_GET['r1']) ? $_GET['r1'] : $this->type;	
		$this->type       = $this->type == '' ? 'wheels' : $this->type;
		$_SESSION['type'] = $this->type;

		if(!$_GET) return null;	
		libxml_use_internal_errors(true);	
		unset($_GET['r1']);

		$this->parsers['wheels']          = new Wheels($_GET);	
		$this->parsers['tires']           = new Tires($_GET);
		$this->parsers['tires_in_detail'] = new TiresInDetail($_GET);

		return $this->parsers[$this->type]->parse();
	}

	/**
	 * Get filter sidebar
	 * @param  array $items --- filter items
	 * @return string       --- html code
	 */
	public function getSidebar($items)
	{
		if(!$items) return '';
		return $this->parsers[$this->type]->getFilterSidebar($items);		
	}

	public function getPagination($items)
	{
		if(!$items) return '';
		return $this->parsers[$this->type]->getPagination($items);
	}

	public function wrapItems($items)
	{	
		if(!$items) return $this->loadTemplatePart('notfound');
		return $this->parsers[$this->type]->wrapItems($items);			
	}

	public function getTableHead()
	{
		if(!isset($this->parsers[$this->type])) return '';
		return $this->parsers[$this->type]->getTableHead();	
	}
}

// =========================================================
// LAUNCH
// =========================================================
$GLOBALS['shop_page'] = new Shop();