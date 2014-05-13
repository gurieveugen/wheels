<?php

class Shop{
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct()
	{

	}

	/**
	 * Get select control
	 * @param  string $name   --- control name
	 * @param  array  $values --- options array
	 * @return string         --- html code select control
	 */
	public function getSelectControl($name, $values)	
	{
		$options = '';
		if(is_array($values))
		{
			foreach ($values as &$val) 
			{
				$options.= sprintf('<option value="%s">%s</option>', $val, $val);
			}
		}
		return sprintf('<select name="%s" id="%s">%s</select>', $name, $name, $options);
	}

	/**
	 * Get revers years array
	 * @param  integer $limit --- how much year we return
	 * @return array          --- revers years. Example: 2014, 2013, 2012 ...
	 */
	public function getReversYears($limit = 100)
	{
		$y = date('Y');
		for ($i=$y; $i > ($y - $limit); $i--) 
		{ 
			$arr[] = $i;
		}
		return $arr;
	}
}

// =========================================================
// LAUNCH
// =========================================================
$GLOBALS['shop'] = new Shop();