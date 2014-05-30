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
		var_dump($url);	
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
		$defaults = '';
		ob_start();
		?>
		<div class="left-content">
		    <div class="filter-title">
		        <span>FILTER BY</span>
		        <a href="/shop?<?php echo $this->getResetQuery($this->filter_fields, $this->request); ?>">(Reset Filters)</a>
		    </div>
		    <!-- /.filter-title -->

		   <div class="accordion tires-filter">
		        <form action="/shop" name="tires_filter" id="tires_filter">                            
		            <?php echo $this->arrayToHideInputs($this->request); ?>
		            <div class="accordion-group">
		                <div class="accordion-heading">
		                    <a href="#collapseNull" class="accordion-toggle"><b class="down-caret"></b>Price</a>
		                </div>
		                <div class="accordion-body in collapse" id="collapseNull">
		                    <div class="accordion-inner">
	                        	<input type="text" name="priceFilter" value="400">                                         
		                    </div>
		                </div>
		            </div>
		            <div class="accordion-group">
		                <div class="accordion-heading">
		                    <a href="#collapseOne" class="accordion-toggle"><b class="down-caret"></b>Brand</a>
		                </div>
		                <div class="accordion-body in collapse" id="collapseOne">
		                    <div class="accordion-inner">
								<label><input type="checkbox" checked="" value="Avon" name="brands[]"><span>Avon </span></label>
								<label><input type="checkbox" checked="" value="Hankook" name="brands[]"><span>Hankook </span></label>
								<label><input type="checkbox" checked="" value="BFGoodrich" name="brands[]"><span>BFGoodrich </span></label>
								<label><input type="checkbox" checked="" value="Hoosier" name="brands[]"><span>Hoosier </span></label>
								<label><input type="checkbox" checked="" value="Bridgestone" name="brands[]"><span>Bridgestone </span></label>
								<label><input type="checkbox" checked="" value="Kumho" name="brands[]"><span>Kumho </span></label>
								<label><input type="checkbox" checked="" value="Classic" name="brands[]"><span>Classic </span></label>
								<label><input type="checkbox" checked="" value="Michelin" name="brands[]"><span>Michelin </span></label>
								<label><input type="checkbox" checked="" value="Continental" name="brands[]"><span>Continental </span></label>
								<label><input type="checkbox" checked="" value="Pirelli" name="brands[]"><span>Pirelli </span></label>
								<label><input type="checkbox" checked="" value="Dick Cepek" name="brands[]"><span>Dick Cepek </span></label>
								<label><input type="checkbox" checked="" value="Power King" name="brands[]"><span>Power King </span></label>
								<label><input type="checkbox" checked="" value="Dunlop" name="brands[]"><span>Dunlop </span></label>
								<label><input type="checkbox" checked="" value="Sumitomo" name="brands[]"><span>Sumitomo </span></label>
								<label><input type="checkbox" checked="" value="Firestone" name="brands[]"><span>Firestone </span></label>
								<label><input type="checkbox" checked="" value="Toyo" name="brands[]"><span>Toyo </span></label>
								<label><input type="checkbox" checked="" value="Fuzion" name="brands[]"><span>Fuzion </span></label>
								<label><input type="checkbox" checked="" value="Uniroyal" name="brands[]"><span>Uniroyal </span></label>
								<label><input type="checkbox" checked="" value="General" name="brands[]"><span>General </span></label>
								<label><input type="checkbox" checked="" value="Yokohama" name="brands[]"><span>Yokohama </span></label>
								<label><input type="checkbox" checked="" value="Goodyear" name="brands[]"><span>Goodyear </span></label>                                  
		                    </div>
		                </div>
		            </div>
		            <div class="accordion-group">
		                <div class="accordion-heading">
		                    <a href="#collapseTwo" class="accordion-toggle"><b class="down-caret"></b>Performance Category</a>
		                </div>
		                <div class="accordion-body in collapse" id="collapseTwo">
		                    <div class="accordion-inner">
                         		<label class="w100p"><input type="checkbox" checked="" value="EP" name="perfCats[]"><span>Extreme Performance Summer  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="MP" name="perfCats[]"><span>Max Performance Summer  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="UHP" name="perfCats[]"><span>Ultra High Performance Summer  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="HP" name="perfCats[]"><span>High Performance Summer  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="GT" name="perfCats[]"><span>Grand Touring Summer  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="UHPAS" name="perfCats[]"><span>Ultra High Performance All Season  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="HPAS" name="perfCats[]"><span>High Performance All-Season  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="PAS" name="perfCats[]"><span>Performance All-Season  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="GTAS" name="perfCats[]"><span>Grand Touring All-Season  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="ST" name="perfCats[]"><span>Standard Touring All-Season  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="AS" name="perfCats[]"><span>Passenger All-Season  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="PPW" name="perfCats[]"><span>Performance Winter / Snow  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="PSIS" name="perfCats[]"><span>Studless Ice &amp; Snow  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="PSW" name="perfCats[]"><span>Studdable Winter / Snow  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="TEMP" name="perfCats[]"><span>Temporary Spare  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="DRY" name="perfCats[]"><span>Racetrack &amp; Autocross Only  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="WET" name="perfCats[]"><span>Wet Racetrack &amp; Autocross Only  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="STRT" name="perfCats[]"><span>Streetable Track &amp; Competition  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="DRAG" name="perfCats[]"><span>Drag Racing Radials  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="SSTAS" name="perfCats[]"><span>Street/Sport Truck All-Season  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="SST" name="perfCats[]"><span>Street/Sport Truck Summer  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="HR" name="perfCats[]"><span>Highway Rib Summer  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="CSTAS" name="perfCats[]"><span>Crossover/SUV Touring All-Season  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="HAS" name="perfCats[]"><span>Highway All-Season  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="ORAT" name="perfCats[]"><span>On-/Off-Road All-Terrain  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="ORCT" name="perfCats[]"><span>On-/Off-Road Commercial Traction  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="ORMT" name="perfCats[]"><span>Off-Road Maximum Traction  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="LTPW" name="perfCats[]"><span>Performance Winter / Snow  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="LTSIS" name="perfCats[]"><span>Studless Ice &amp; Snow  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="LTSW" name="perfCats[]"><span>Studdable Winter / Snow  </span></label>
                         		<label class="w100p"><input type="checkbox" checked="" value="TS" name="perfCats[]"><span>Trailer  </span></label>                                
		                    </div>
		                </div>
		            </div>
		            <div class="accordion-group">
		                <div class="accordion-heading">
		                    <a href="#collapseThree" class="accordion-toggle"><b class="down-caret"></b>Speed Rating</a>
		                </div>
		                <div class="accordion-body in collapse" id="collapseThree">
		                    <div class="accordion-inner">
                         		<label><input type="checkbox" checked="" value="H" id="speedRatingH" name="speedRatings[]"><span>H: 130mph </span></label>
                         		<label><input type="checkbox" checked="" value="V" id="speedRatingV" name="speedRatings[]"><span>V: 149mph </span></label>
                         		<label><input type="checkbox" checked="" value="Z" id="speedRatingZ" name="speedRatings[]"><span>Z: 149+mph </span></label>
                         		<label><input type="checkbox" checked="" value="W" id="speedRatingW" name="speedRatings[]"><span>W: 168mph </span></label>
                         		<label><input type="checkbox" checked="" value="Y" id="speedRatingY" name="speedRatings[]"><span>Y: 186mph </span></label>
                         		<label><input type="checkbox" checked="" value="(Y)" id="speedRating(Y)" name="speedRatings[]"><span>(Y): 186+mph </span></label>                                        
		                    </div>
		                </div>
		            </div>
		            <div class="accordion-group">
		                <div class="accordion-heading">
		                    <a href="#collapseFour" class="accordion-toggle"><b class="down-caret"></b>Run-Flat</a>
		                </div>
		                <div class="accordion-body in collapse" id="collapseFour">
		                    <div class="accordion-inner">
                        		<label class="w100p"><input type="radio" checked="" value="All" name="RunFlat"><span>Include Run-Flat Tires </span></label>
                        		<label class="w100p"><input type="radio" value="None" name="RunFlat"><span>Do Not Include Run-Flat Tires </span></label>
                        		<label class="w100p"><input type="radio" value="RunFlatOnly" name="RunFlat"><span>Show ONLY Run-Flat Tires </span></label>                              
		                    </div>
		                </div>
		            </div>
		            <div class="accordion-group">
		                <div class="accordion-heading">
		                    <a href="#collapseFive" class="accordion-toggle"><b class="down-caret"></b>Low Rolling Resistance</a>
		                </div>
		                <div class="accordion-body in collapse" id="collapseFive">
		                    <div class="accordion-inner">
	                         	<label class="w100p"><input type="radio" checked="" value="All" name="LRR"><span>Include LRR Tires </span></label>
	                         	<label class="w100p"><input type="radio" value="None" name="LRR"><span>Do Not Include LRR Tires </span></label>
	                         	<label class="w100p"><input type="radio" value="LRROnly" name="LRR"><span>Show ONLY LRR Tires </span></label>                       
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
		$out = '';
		$index = 10;
		foreach ($items as $id => &$item) 
		{
			$index--;
			$hide = $index < 0 ? 'hide' : '';
			$str  = $this->wrapItem($item, $id);
			$out .= $str != '' ? sprintf('<tr class="%s">%s</tr>', $hide, $str) : '';	
		}
		
		return $out;
	}

	/**
	 * Wrap one result item
	 * @param  array $item --- one item
	 * @param  integer $id --- $item array key
	 * @return string      --- HTML code
	 */
	public function wrapItem($item, $id = 0)
	{		
		if(!$item) return '';

		ob_start();
		$price_txt   = $item->isOnSpecial ? '<span class="red">Special</span>' : '';
		$price_txt   = $item->isOnClearance ? '<span class="red">Closeout</span>' : $price_txt;
		$mark_down   = $item->markdownPrice != '0' ? sprintf('<b>%s</b><br>', $item->markdownPriceFormatted) : '';
		$promo       = $item->promoLongText != '' ? sprintf('<div class="promo-block"><span class="red">Special Offer: </span>%s</div>', $item->promoLongText) : '';
		$new         = $item->isNew ? '<div class="new-img"></div>' : '';
		$OE          = $item->isOE ? '<div class="oe-img"></div>' : '';
		$best_seller = $item->isBestSeller ? '<div class="best-seller-img"></div>' : '';
		$rhp_price   = $item->rhpPrice > 0 ? sprintf('<div class="rhp"><img src="/images/css_elements/searchResults/rhpIcon.gif" alt="">Optional <u>Road Hazard Program:</u> %s</div>', $item->rhpPriceFormatted) : '<div class="rhp"><u>Includes Manufacturer\'s Road Hazard Warranty</u></div>';
		?>
		<td id="td-<?php echo $id; ?>">
			<?php // var_dump($item); ?>
			<div class="tires">				
				<div class="title-block">
					<?php echo $item->tireMake.' '.$item->tireModel; ?>
				</div>	
				<div class="compare-block">
					<input type="checkbox"><br>
					<img src="/images/search_buttons/compare.gif" alt="">
				</div>			
				<div class="img-block">
					<?php echo $new; ?>
					<?php echo $OE; ?>
					<?php echo $best_seller; ?>
					<img src="<?php echo $item->image; ?>" alt="<?php echo $item->tireModel; ?>">
					<br><br>
					<small>Consumer rating:</small><br>
					<?php echo getStars($item->starRating); ?><br>
					<br>
					<small>Warranty rating:</small><br>
					<?php echo getStars($item->imageSumRating); ?><br>
				</div>
				<div class="description-block">
					<?php echo $promo; ?>
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
								<?php echo $mark_down; ?> <b class="red price" data-price="<?php echo $item->price; ?>"><?php echo $item->priceFormatted; ?></b> (each) <?php echo $price_txt; ?><br>	
							</div>
						</div> 
						<b>Estimated Availability:</b> <?php echo $item->stockMessage; ?> <br>
						Shipping Cost/Delivery Date
					</div>	
					<div class="third-info-block">
						<label for="factor">Qty:</label>
						<select name="factor" class="factor" data-price="<?php echo $item->price; ?>">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
						</select>
					</div>
					<?php echo $rhp_price; ?>	
					<div class="footer">
						<b><a href="#">Additional Tire Information</a></b>
						<ul class="menu">
							<li><a href="#">Product Description</a></li>  | 
							<li><a href="#">Specs</a></li> | 
							<li><a href="#">Surveys</a></li>  | 
							<li><a href="#">Reviews</a></li>  | 
							<li><a href="#">Tests</a></li>  | 
							<li><a href="#">Warranty</a></li>							
						</ul>
					</div>		
				</div>
				<div class="buttons-block">
					<i class="fa fa-shopping-cart fa-6" style="font-size: 7em"></i><br>
					Set of <span class="count">1</span>: <span class="sum red"><?php echo $item->priceFormatted; ?></span><br><br>
					<a href="#" class="btn">ADD TO CART</a>					
				</div>
			</div>
			
		</td>
		<?php
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}

	public function getPagination($items)
	{		
		$count = count($items);
		$pages = ceil($count / 10);
		ob_start();
		?>
		<div class="pagination-block">
			<span class="view-all"><a href="#" class="view-all-btn" data-count="<?php echo $count; ?>">View all <?php echo $count; ?> results</a></span>
			<span> |   View Per Page:</span>
			<select name="select-view" class="select-view" data-count="<?php echo $count; ?>">
				<option value="10">10</option>
				<option value="25">25</option>
				<option value="50">50</option>
				<option value="<?php echo $count; ?>">All</option>
			</select>
			|
			<ul class="pagination-list">
				<li><a class="previous button" href="#" data-val="0" data-count="10"><span>&lt;</span></a></li>
				<?php
				for ($i=1; $i <=  $pages; $i++) 
				{ 
					if($i == 1)
					{
						printf('<li>%s</li>', $i);
					}
					else
					{
						printf('<li><a href="#" data-val="%1$s" data-count="10" data-count-all="%2$s">%1$s</a></li>', $i, $count);	
					}					
				}
				?>
				<li><a href="#" class="activenext button" data-val="2" data-count="10"><span>&gt;</span></a></li>
			</ul>
		</div>
		<?php
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}



}