<?php 

class Options{
	//                          __              __      
	//   _________  ____  _____/ /_____ _____  / /______
	//  / ___/ __ \/ __ \/ ___/ __/ __ `/ __ \/ __/ ___/
	// / /__/ /_/ / / / (__  ) /_/ /_/ / / / / /_(__  ) 
	// \___/\____/_/ /_/____/\__/\__,_/_/ /_/\__/____/  
	const SESSION_FIELD = 'PARSER';
	//                                       __  _          
	//     ____  _________  ____  ___  _____/ /_(_)__  _____
	//    / __ \/ ___/ __ \/ __ \/ _ \/ ___/ __/ / _ \/ ___/
	//   / /_/ / /  / /_/ / /_/ /  __/ /  / /_/ /  __(__  ) 
	//  / .___/_/   \____/ .___/\___/_/   \__/_/\___/____/  
	// /_/              /_/                                 	
	public $options; 
	private $options_fields; 
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/ 
	public function __construct($request = null)
	{
		$this->_session_start();
		$this->options_fields = array('autoMake', 'autoYear', 'autoModel', 'autoModClar');
		$this->saveOptions($request);
		$this->loadOptions();
	}

	/**
	 * Put options to session
	 * @param  array $request --- request
	 */
	public function saveOptions($request)
	{		
		if(!$request) return;			
		foreach ($this->options_fields as &$opt) 
		{
			$result[$opt] = isset($request[$opt]) && $request[$opt] != null ? $request[$opt] : null;			
		}
		$_SESSION[self::SESSION_FIELD] = $result;
	} 

	/**
	 * Get all options 
	 * @return mixed --- array | null
	 */
	public function getOptions()
	{
		return isset($_SESSION[self::SESSION_FIELD]) ? $_SESSION[self::SESSION_FIELD] : array();
	}

	/**
	 * Load options
	 */
	public function loadOptions()
	{
		$defaults = array(			
			'autoMake'    => '', 
			'autoYear'    => '', 
			'autoModel'   => '', 
			'autoModClar' => '');
		$options = $this->getOptions();
		$options = array_merge($defaults, $options);
		$this->options = $options;
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
	
	/**
	 * Helper class for select control
	 * @param  boolean $yes --- return select or empty string
	 * @return string 		--- select | empty string
	 */
	public function selected($yes)
	{
		return $yes ? 'selected' : '';
	}

	/**
	 * Helper class for radio|checkbox control
	 * @param  boolean $yes --- return checked or empty string
	 * @return string 		--- checked | empty string
	 */
	public function checked($yes)
	{
		return $yes ? 'checked' : '';
	}
}