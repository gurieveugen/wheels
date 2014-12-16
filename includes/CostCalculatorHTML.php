<?php

class CostCalculatorHTML{
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct()
	{

	}	

	public function getHTML()
	{
		ob_start();
		?>
		<form action="" method="post" id="calculator">
			<div class="accordion" id="accordion2">
			    <div class="accordion-group">
			        <div class="accordion-heading">
			            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_parameters"><h1>Parameters</h1></a>
			        </div>
			        <div style="height: 0px;" id="collapse_parameters" class="accordion-body collapse">
			            <div class="accordion-inner">
			                <?php echo $this->getParametersHTML(); ?>
			            </div>
			        </div>
			    </div>
			    <div class="accordion-group">
			        <div class="accordion-heading">
			            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_tire_service"><h1>Tire service</h1></a>
			        </div>
			        <div style="height: auto;" id="collapse_tire_service" class="accordion-body in collapse">
			            <div class="accordion-inner">
			                <?php echo $this->getTireServiceHTML(); ?>
			            </div>
			        </div>
			    </div>
			    <div class="accordion-group">
			        <div class="accordion-heading">
			            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_discs_repair"><h1>Discs repair</h1></a>
			        </div>
			        <div style="height: auto;" id="collapse_discs_repair" class="accordion-body in collapse">
			            <div class="accordion-inner">
			                <?php echo $this->getDiscsRepairHTML(); ?>
			            </div>
			        </div>
			    </div>
			     <div class="accordion-group">
			        <div class="accordion-heading">
			            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_discs_painting"><h1>Discs painting</h1></a>
			        </div>
			        <div style="height: auto;" id="collapse_discs_painting" class="accordion-body in collapse">
			            <div class="accordion-inner">
			                <?php echo $this->getDiscsPaintingHTML(); ?>
			            </div>
			        </div>
			    </div>
			     <div class="accordion-group">
			        <div class="accordion-heading">
			            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_polishing_board"><h1>Polishing board</h1></a>
			        </div>
			        <div style="height: auto;" id="collapse_polishing_board" class="accordion-body in collapse">
			            <div class="accordion-inner">
			                <?php echo $this->getPolishingBoardHTML(); ?>
			            </div>
			        </div>
			    </div>
			     <div class="accordion-group">
			        <div class="accordion-heading">
			            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_other_service"><h1>Other service</h1></a>
			        </div>
			        <div style="height: auto;" id="collapse_other_service" class="accordion-body in collapse">
			            <div class="accordion-inner">
			                <?php echo $this->getOtherServiceHTML(); ?>
			            </div>
			        </div>
			    </div>
			</div>
			<div id="result" class="row">
				
			</div>
			<button class="btn btn-danger" type="reset">Reset</button>
			<button id="calculate-btn" class="btn btn-success" type="submit">Calculation</button>
		</form>
		<?php
		
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}  

	/**
	 * Get other service HTML code
	 * @return string --- HTML code
	 */
	private function getOtherServiceHTML()
	{
		ob_start();
		?>
		<div class="row">
			<div class="span3">
				<label for="storage">Storage</label>
			</div>
			<div class="span8">
				<input type="checkbox" name="storage" id="storage">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="refill">Refill</label>
			</div>
			<div class="span8">
				<input type="checkbox" name="refill" id="refill">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="processing_welding">Processing welding</label>
			</div>
			<div class="span8">
				<input type="checkbox" name="processing_welding" id="processing_welding">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="argon_welding">Argom welding (cm)</label>
			</div>
			<div class="span8">
				<input type="text" name="argon_welding" id="argon_welding" value="0">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="scraping_corrosion">Scraping corrosion, <br> primer coating ( pcs. )</label>
			</div>
			<div class="span8">
				<input type="text" name="scraping_corrosion" id="scraping_corrosion" value="0">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="disposing_of_rubber">Disposing of rubber ( pcs. )</label>
			</div>
			<div class="span8">
				<input type="text" name="disposing_of_rubber" id="disposing_of_rubber" value="0">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="solving_punctures_cameras">Solving punctures cameras ( puncture )</label>
			</div>
			<div class="span8">
				<input type="text" name="solving_punctures_cameras" id="solving_punctures_cameras" value="0">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="solving_punctures_tires">Solving punctures tires ( puncture )</label>
			</div>
			<div class="span8">
				<input type="text" name="solving_punctures_tires" id="solving_punctures_tires" value="0">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="technological_wheel_wash">Technological wheel wash ( pcs. )</label>
			</div>
			<div class="span8">
				<input type="text" name="technological_wheel_wash" id="technological_wheel_wash" value="0">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="valve_standart">Replacing a valve ( standart )</label>
			</div>
			<div class="span8">
				<input type="text" name="valve_standart" id="valve_standart" value="0">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="valve_chrome">Replacing a valve ( chromium-plated )</label>
			</div>
			<div class="span8">
				<input type="text" name="valve_chrome" id="valve_chrome" value="0">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="spacer_rings">Spacer rings ( pcs. )</label>
			</div>
			<div class="span8">
				<input type="text" name="spacer_rings" id="spacer_rings" value="0">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="finish_balancing_front_axle">Finish balancing front axle</label>
			</div>
			<div class="span8">
				<input type="text" name="finish_balancing_front_axle" id="finish_balancing_front_axle" value="0">
			</div>
		</div>
		
		<div class="row">
			<div class="span3">
				<label for="finish_balancing_rear_axle">Finish balancing rear axle</label>
			</div>
			<div class="span8">
				<input type="text" name="finish_balancing_rear_axle" id="finish_balancing_rear_axle" value="0">
			</div>
		</div>

		<?php
		
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}

	/**
	 * Get discs painting HTML code
	 * @return string --- HTML code
	 */
	private function getPolishingBoardHTML()
	{
		ob_start();
		?>
		<div class="row">
			<div class="span3">
				<label for="pb_number_of_discs">Number of discs</label>
			</div>
			<div class="span8">
				<input type="text" name="pb_number_of_discs" id="pb_number_of_discs" value="0">
			</div>
		</div>

		<div class="row">
			<h2>Polishing type:</h2>
		</div>

		<div class="row">
			<div class="span3">
				<label for="narrow_board">Narrow board</label>
			</div>
			<div class="span8">
				<input type="radio" name="polishing_type" id="narrow_board" value="narrow_board">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="wide_board">Wide board</label>
			</div>
			<div class="span8">
				<input type="radio" name="polishing_type" id="wide_board" value="wide_board">
			</div>
		</div>
		<?php
		
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}

	/**
	 * Get discs painting HTML code
	 * @return string --- HTML code
	 */
	private function getDiscsPaintingHTML()
	{
		ob_start();
		?>
		<div class="row">
			<div class="span3">
				<label for="dp_number_of_discs">Number of discs</label>
			</div>
			<div class="span8">
				<input type="text" name="dp_number_of_discs" id="dp_number_of_discs" value="0">
			</div>
		</div>
		<div class="row">
			<h2>Painting type:</h2>
		</div>

		<div class="row">
			<div class="span3">
				<label for="full_painting">Full painting</label>
			</div>
			<div class="span8">
				<input type="radio" name="painting_type" id="full_painting" value="full_painting">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="paint_the_front">Paint the front</label>
			</div>
			<div class="span8">
				<input type="radio" name="painting_type" id="paint_the_front" value="paint_the_front">
			</div>
		</div>
		<?php
		
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}

	/**
	 * Get paramteres HTML code
	 * @return string --- parameters HTML code
	 */
	private function getParametersHTML()
	{
		ob_start();
		?>
		<div class="row">
			<div class="span3">
				<label for="vehicle_type">Vehicle type</label>
			</div>
			<div class="span8">
				<select name="vehicle_type" id="vehicle_type">
					<option value="0">Passengers cars</option>
					<option value="1">Other cars</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="span3">
				<label for="disc_type">Disc type</label>
			</div>
			<div class="span8">
				<select name="disc_type" id="disc_type">
					<option value="0">Alloy wheels</option>
					<option value="1">Steel wheels</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="span3">
				<label for="tyre_type">Tyre type runflat</label>
			</div>
			<div class="span8">
				<input type="checkbox" name="tyre_type" id="tyre_type">
			</div>
		</div>
		<div class="row">
			<div class="span3">
				<label for="disc_size">Disc size</label>
			</div>
			<div class="span8">
				<select name="disc_size" id="disc_size">
					<?php echo $this->getDiscSizes(); ?>
				</select>
			</div>
		</div>
		<?php
		
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	} 

	/**
	 * Get tire service HTML code
	 * @return string --- HTML code
	 */
	private function getTireServiceHTML()
	{
		ob_start();
		?>
		<div class="row">
			<div class="span3">
				<label for="ts_number_of_wheels">Number of wheels</label>
			</div>
			<div class="span8">
				<input type="text" name="ts_number_of_wheels" id="ts_number_of_wheels" value="0">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="remove_instllation">Removal \ Installation</label>
			</div>
			<div class="span8">
				<input type="checkbox" name="remove_instllation" id="remove_instllation">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="removing_tyre">Removing Tyre</label>
			</div>
			<div class="span8">
				<input type="checkbox" name="removing_tyre" id="removing_tyre">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="mounting_tyre">Mounting Tyre</label>
			</div>
			<div class="span8">
				<input type="checkbox" name="mounting_tyre" id="mounting_tyre">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="tire_balancing">Tire balancing</label>
			</div>
			<div class="span8">
				<input type="checkbox" name="tire_balancing" id="tire_balancing">
			</div>
		</div>
		<?php
		
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}

	/**
	 * Get tire service HTML code
	 * @return string --- HTML code
	 */
	private function getDiscsRepairHTML()
	{
		ob_start();
		?>
		<div class="row">
			<div class="span3">
				<label for="dr_number_of_discs">Number of discs</label>
			</div>
			<div class="span8">
				<input type="text" name="dr_number_of_discs" id="dr_number_of_discs" value="0">
			</div>
		</div>
		<div class="row">
			<h2>Damage type:</h2>
		</div>

		<div class="row">
			<div class="span3">
				<label for="radial_ronout">Radial runout</label>
			</div>
			<div class="span8">
				<input type="radio" name="damage_type" id="radial_ronout" value="radial_ronout">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="axial_displacement">Axial displacement</label>
			</div>
			<div class="span8">
				<input type="radio" name="damage_type" id="axial_displacement" value="axial_displacement">
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="rr_and_ad">Radial runout and axial displacement</label>
			</div>
			<div class="span8">
				<input type="radio" name="damage_type" id="rr_and_ad" value="rr_and_ad">
			</div>
		</div>
		<?php
		
		$var = ob_get_contents();
		ob_end_clean();
		return $var;
	}

	/**
	 * Get disc sizes HTML code
	 * @return string --- get dics sizes HTML code
	 */
	private function getDiscSizes()
	{
		$taxonomies = array( 
		    'size'
		);

		$args = array(
		    'orderby'           => 'name', 
		    'order'             => 'ASC',
		    'hide_empty'        => true, 
		    'exclude'           => array(), 
		    'exclude_tree'      => array(), 
		    'include'           => array(),
		    'number'            => '', 
		    'fields'            => 'all', 
		    'slug'              => '', 
		    'parent'            => '',
		    'hierarchical'      => true, 
		    'child_of'          => 0, 
		    'get'               => '', 
		    'name__like'        => '',
		    'description__like' => '',
		    'pad_counts'        => false, 
		    'offset'            => '', 
		    'search'            => '', 
		    'cache_domain'      => 'core'
		); 

		$sizes = get_terms($taxonomies, $args);
		$out   = '';
		if(count($sizes))
		{
			foreach ($sizes as $size) 
			{
				$out .= sprintf('<option value="%d">%s</option>', $size->term_id, $size->name);
			}
		}
		return $out;
	}                                         
}