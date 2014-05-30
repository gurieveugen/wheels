<?php

require_once 'base.php';

class Wheels extends Base{
	//                                       __  _          
	//     ____  _________  ____  ___  _____/ /_(_)__  _____
	//    / __ \/ ___/ __ \/ __ \/ _ \/ ___/ __/ / _ \/ ___/
	//   / /_/ / /  / /_/ / /_/ /  __/ /  / /_/ /  __(__  ) 
	//  / .___/_/   \____/ .___/\___/_/   \__/_/\___/____/  
	// /_/              /_/                                 
	public $filter_fields;
	public $select_fields;	
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct($request)
	{
		parent::__construct($request);		
		$this->filter_fields = array('filterSize', 'filterFinish', 'filterBrand', 'filterWeight', 'filterNew');
		$this->select_fields = array('autoMake', 'autoYear', 'autoModel', 'autoModClar');		
		$this->request       = $this->requestInit($request);
		$this->request_http  = http_build_query($this->request);
	}	 

	public function parse()
	{		
		$dom       = new DOMDocument();
		$block_dom = new DOMDocument();	
		$cookie    = $this->getCookieSession();				
		$url       = $this->isFiltering($this->request, $this->filter_fields) ? sprintf(self::SESSION_URL, $this->request_http) : sprintf(self::WHEELS_URL, $this->request_http);					
		$html      = $this->fileGetContentsCurl($url, $cookie, false);		
		$dom->loadHTML($html);
		
		$xpath         = new DOMXPath($dom);
		$blocks        = $xpath->query(".//*[@id='alloy']/div/div[@class='maincontainer']");
		$paging        = $xpath->query(".//*[@id='alloy']/table");
		$filter_size   = $xpath->query(".//*[@id='filterSize_id']");
		$filter_finish = $xpath->query(".//*[@id='filterFinish_id']");
		$filter_brand  = $xpath->query(".//*[@id='filterBrand_id']");
		$filter_weight = $xpath->query(".//*[@id='filterWeight_id']");
		$index         = 0;

		if(!$blocks->length) return null;
		$_SESSION['get'] = $this->request;

		$items['paging'] = $paging->item(0)->ownerDocument->saveHTML($paging->item(0));		
		$items['paging'] = str_replace('/wheels/WheelGridControlServlet', '/shop', $items['paging']);
		$items['paging'] = preg_replace('/<table.*?>/', '<table width="100%" cellspacing="0" cellpadding="0" class="paging-table">', $items['paging']);
		$items['paging'] = str_replace('<td align="right">', '<td class="text-right numbers">', $items['paging']);
		$items['paging'] = $this->pageTo_Page($items['paging']);

		$items['filter_size']   = $filter_size->item(0)->ownerDocument->saveHTML($filter_size->item(0));
		$items['filter_finish'] = $filter_finish->item(0)->ownerDocument->saveHTML($filter_finish->item(0));
		$items['filter_brand']  = $filter_brand->item(0)->ownerDocument->saveHTML($filter_brand->item(0));
		$items['filter_weight'] = $filter_weight->item(0)->ownerDocument->saveHTML($filter_weight->item(0));

		foreach ($blocks as $block) 
		{
			$block_dom->loadHTML($block->ownerDocument->saveHTML($block));			
			$block_x         = new DOMXPath($block_dom);
			$wheel           = $block_x->query(".//*[@class='maincontainer']/div[1]/div[@class='imagelinks']/a/img");			
			$logo            = $block_x->query(".//*[@class='maincontainer']/div[1]/p/a/img");
			$description     = $block_x->query(".//*[@class='maincontainer']/div[1]/h4/a");
			$cat_tabs        = $block_x->query(".//*[@class='maincontainer']/ul[@class='cat-tabs']");
			$wheel_info      = $block_x->query(".//*[@class='maincontainer']/div[@class='wheelInfo']");
			$wheel_info_btn  = $block_x->query(".//*[@class='maincontainer']/div[@class='wheelInfo']/div[@class='btmBTNContainer']");
			$view_on_vehicle = $block_x->query(".//*[@class='maincontainer']/div[@class='wheelInfo']/div[@class='btmBTNContainer']/div[@class='vovDetailLinks']/div[1]/a");
			$text            = $block_x->query(".//*[@class='maincontainer']/div[1]/h4");

			$text = $text->item(0)->ownerDocument->saveHTML($text->item(0));
			$text = preg_replace('/<a.*?<\/a>/', '', $text);
			$text = trim(str_replace(array('<br>', '<h4>', '</h4>'), '', $text));


			$wheel_info_str     = $wheel_info->item(0)->ownerDocument->saveHTML($wheel_info->item(0));
			$wheel_info_btn_str = $wheel_info_btn->item(0)->ownerDocument->saveHTML($wheel_info_btn->item(0));
			$wheel_info_str     = str_replace($wheel_info_btn_str, '', $wheel_info_str);

			$items[] = array(
				'index'           => $index++,
				'wheel_img'       => $this->getAttribute($wheel),
				'logo_img'        => $this->getAttribute($logo),
				'cat_tabs_html'   => $cat_tabs->item(0)->ownerDocument->saveHTML($cat_tabs->item(0)),
				'wheel_info_html' => $wheel_info_str,				
				'view_on_vehicle' => $this->getAttribute($view_on_vehicle, 'href'),
				'text'			  => $text,
				'description'     => array(
					'href'      => $this->getAttribute($description, 'href'),
					'value'     => $description->item(0)->nodeValue));			
		}

		return $items;
	}

	/**
	 * Get table head
	 * @return string --- html code
	 */
	public function getTableHead()
	{
		return '';
	}

	public function getPaginaion()
	{
		return '';
	}

	/**
	 * Get Filter sidebar
	 * @return string
	 */
	public function getFilterSidebar($items)
	{
		ob_start();
		?>
		<div class="left-content">
		    <div class="filter-title">
		        <span>FILTER BY</span>
		        <a href="/shop?<?php echo $this->getResetQuery($this->filter_fields, $this->request); ?>">(Reset Filters)</a>
		    </div>
		    <!-- /.filter-title -->

		   <div class="accordion">
		        <form action="/shop">                            
		            <?php echo $this->arrayToHideInputs($this->request, 'wheels'); ?>
		            <div class="accordion-group">
		                <div class="accordion-heading">
		                    <a href="#collapseOne" class="accordion-toggle"><b class="down-caret"></b>Diameter</a>
		                </div>
		                <div class="accordion-body in collapse" id="collapseOne">
		                    <div class="accordion-inner">
		                         <?php echo $items['filter_size']; ?>                                         
		                    </div>
		                </div>
		            </div>
		            <div class="accordion-group">
		                <div class="accordion-heading">
		                    <a href="#collapseTwo" class="accordion-toggle"><b class="down-caret"></b>Finish</a>
		                </div>
		                <div class="accordion-body in collapse" id="collapseTwo">
		                    <div class="accordion-inner">
		                         <?php echo $items['filter_finish']; ?>                                        
		                    </div>
		                </div>
		            </div>
		            <div class="accordion-group">
		                <div class="accordion-heading">
		                    <a href="#collapseThree" class="accordion-toggle"><b class="down-caret"></b>Brand</a>
		                </div>
		                <div class="accordion-body in collapse" id="collapseThree">
		                    <div class="accordion-inner">
		                         <?php echo $items['filter_brand']; ?>                                         
		                    </div>
		                </div>
		            </div>
		            <div class="accordion-group">
		                <div class="accordion-heading">
		                    <a href="#collapseFour" class="accordion-toggle"><b class="down-caret"></b>Weight</a>
		                </div>
		                <div class="accordion-body in collapse" id="collapseFour">
		                    <div class="accordion-inner">
		                         <?php echo $items['filter_weight']; ?>                                        
		                    </div>
		                </div>
		            </div>
		        </form>		       
		   </div>
		   <!-- /.accordion -->

		</div>
		<!-- /.left-content -->
		<?php
		$var = ob_get_contents();
    	ob_end_clean();
    	return $var;
	}

	/**
	 * Initialize request
	 * @param  array $request --- request array
	 * @return array          --- initialized request
	 */
	private function requestInit($request)
	{
		if(!$request) return null;		
		
		foreach ($this->select_fields as $field) 
		{
			if(isset($request[$field]))
			{
				$tmp[$field] = $request[$field];				
			}
		}
		$request       = $this->_pageToPage($request);
		$request['qs'] = $this->joinArray($tmp);
		return $request;
	}      

	/**
	 * Wrap all items
	 * @param  array $items --- items array
	 * @return string       --- HTML code
	 */
	public function wrapItems($items)
	{
		if(!$items) return $this->loadTemplatePart('notfound');

		$out = '';
		for ($i=0; $i < count($items); $i+=2) 
		{ 
			$out.= '<tr>';
			for ($j=0; $j < 2; $j++) 
			{ 
				if(isset($items[$i+$j])) $out.= $this->wrapItem($items[$i+$j]);
			}
			$out.= '</tr>';
			
		}
		$out.= sprintf('<tr>%s</tr>', $items['paging']);
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
		<td>
			<div class="left-side">
				<div class="image">
					<img src="<?php echo $item['wheel_img']; ?>" alt="">
				</div>
				<?php echo $item['cat_tabs_html']; ?>
			</div>
			<div class="right-side">
				<div class="image">
					<a href="#"><img src="<?php echo $item['logo_img']; ?>" alt=""></a>
				</div>
				<?php echo $item['description']['value']; ?><br><br>
				<span class="description">
					<?php echo $item['text']; ?>
				</span><br>
				<a href="<?php echo $item['view_on_vehicle']; ?>" class="link view-on-vehicle" onclick="popUp(this); return false;" target="_blank"><b>View on Vehicle</b></a>
			</div>
			<?php echo $this->wrapItemInfo($item['index'], $item['wheel_info_html']); ?>
		</td>
		<?php
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}

	/**
	 * Wrap item info blcok
	 * @param  integer $id  --- item id
	 * @param  string $text --- HTML code
	 * @return string       --- HTML code
	 */
	public function wrapItemInfo($id, $text)
	{
		ob_start();
		?>
		<div style="display: none" class="modal" id="block-<?php echo $id; ?>">		    
		    <div class="body text-center">			        
		        <?php echo $text; ?>
		   	</div>
		    <div class="footer">
		    	<a href="#" data-dismiss="modal" onclick="hideDialog(\'#block-<?php echo $id; ?>\')" class="btn btn-shop btn-success right">Hide description</a>
		    </div>
		</div>
		<?php
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}                                     	
}