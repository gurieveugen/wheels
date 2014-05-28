<?php
require_once 'base.php';
class TiresInDetail extends base{
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
		$block_dom = new DOMDocument();	
		$cookie    = $this->getCookieSession();
		$url       = sprintf(self::TIRES_IN_DETAIL_URL, $this->request_http);		
		$html      = $this->fileGetContentsCurl($url, $cookie, false);
		preg_match_all('/(?s)tireList\[i\] = \{.*?\}/', $html, $out);

		$str = str_replace('tireList[i] = ', '', $out[0][0]);
		if(isset($out[0]) && is_array($out[0]))
		{
			foreach ($out[0] as $key => &$value) 
			{
				$items[$key] = $this->javaJSONDecode(str_replace('tireList[i] = ', '', $value));	
			}	
		}
		

		return $items;
	}

	/**
	 * Custom Decode JSON
	 * @param  string $s --- string to decode
	 * @return array     --- decoded array
	 */
	public function javaJSONDecode($s) 
	{		
		$s = str_replace(' i,', ' 0,', $s);	
		$s = str_replace('""', '\'\'', $s);	
		$s = str_replace('",', '\',', $s);
		$s = str_replace(' "', ' \'', $s);
		$s = str_replace( array('"',  "'"), array('\"', '"'), $s );
		
	    $s = preg_replace('/(\w+):\s/i', '"\1":', $s);	    
	    return json_decode($s);
	}

	/**
	 * Get table head
	 * @return string --- html code
	 */
	public function getTableHead()
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
	 * Wrap all items
	 * @param  array $items --- items array
	 * @return string       --- HTML code
	 */
	public function wrapItems($items)
	{
		if(!$items) return $this->loadTemplatePart('notfound');

		foreach ($items as &$item) 
		{
			$out.= sprintf('<tr>%s</tr>', $this->wrapItem($item));	
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
		$price_txt = $item->isOnSpecial ? '<span class="red">Special</span>' : '';
		$price_txt = $item->isOnClearance ? '<span class="red">Closeout</span>' : $price_txt;
		$mark_down = $item->markdownPrice != '0' ? sprintf('<b>%s</b><br>', $item->markdownPriceFormatted) : '';
		?>
		<td>
			<div class="tires">
				<div class="title-block">
					<?php echo $item->tireModel; ?>
				</div>
				<div class="img-block">
					<img src="<?php echo $item->image; ?>" alt="<?php echo $item->tireModel; ?>">
				</div>
				<div class="first-info-block">
					<b>Size:</b> <?php echo $item->displaySize; ?><br>
					<?php echo $item->clarifier; ?><br>
					<b>Sidewall Style:</b> <?php echo $item->sidewall; ?><br>
					<b>Serv. Desc:</b> <?php echo $item->serviceDesc; ?><br>
					<b>UTQG:</b> <?php echo $item->utqgTreadwear.' '.$item->utqgTraction.' '.$item->utqgTemperature; ?>
				</div>	
				<div class="second-info-block">					
					<div class="price-wrap">
						<span class="title">
							<b>Price:</b> 
						</span>
						<div class="txt">
							<?php echo $mark_down; ?> <b class="red"><?php echo $item->priceFormatted; ?></b> (each) <?php echo $price_txt; ?><br>	
						</div>
					</div> 
					<b>Estimated Availability:</b> <?php echo $item->stockMessage; ?> <br>
					Shipping Cost/Delivery Date
				</div>			
			</div>
			<?php var_dump($item); ?>
		</td>
		<?php
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}

}