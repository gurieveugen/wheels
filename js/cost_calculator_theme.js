function CostCalculator()
{
	//                                       __  _          
	//     ____  _________  ____  ___  _____/ /_(_)__  _____
	//    / __ \/ ___/ __ \/ __ \/ _ \/ ___/ __/ / _ \/ ___/
	//   / /_/ / /  / /_/ / /_/ /  __/ /  / /_/ /  __(__  ) 
	//  / .___/_/   \____/ .___/\___/_/   \__/_/\___/____/  
	// /_/              /_/                                 
	var $this = this;
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	$this.calculate = function(){
		$this.form_query = $this.getQuery('#calculator');

		jQuery.ajax({
			url: cost_calculator_data.ajax_url + '?action=calculate',
			dataType: 'json',
			type: 'GET',
			data: {
				size: jQuery('#disc_size').val()
			},
			success: function(response){
				var fields = $this.getFields( $this.form_query );
				var values = $this.concat( $this.getValues(fields, response), $this.getOtherServiceValues() );
				var print  = new CalculatorPrint();

				print.add( $this.calculateTireService(values) );
				print.add( $this.calculateDiscsRepari(values) );
				print.add( $this.calculateDiscsPainting(values) );
				print.add( $this.calculatePolishingBoard(values) );
				print.add( $this.calculateOtherService(values) );
				print.display();
			}
		});
	};

	/**
	 * Get other service values
	 * @return json --- values
	 */
	$this.getOtherServiceValues = function(){
		var field  = '';
		var values = {};
		for( var key in cost_calculator_data.options )
		{
			field = key.split('_').slice(1).join('_');
			values[field] = parseFloat( cost_calculator_data.options[key] );
		}
		return values;
	};

	/**
	 * Calculate Other service section
	 * @param  json values --- values 
	 * @return json --- title, sum
	 */
	$this.calculateOtherService = function(values){
		var checkbox_fields = ['storage', 'refill', 'processing_welding'];
		var input_fields = [
			'argon_welding',
			'disposing_of_rubber',
			'solving_punctures_cameras',
			'solving_punctures_tires',
			'technological_wheel_wash',
			'valve_standart',
			'valve_chrome',
			'spacer_rings',
		];
		var sum = 0;
		var field = '';
		var vehicle_type = $this.form_query['vehicle_type'];

		// ==============================================================
		// Checkboxes
		// ==============================================================
		for( var i = 0; i < checkbox_fields.length; i++ )
		{
			field = checkbox_fields[i];
		
			if( typeof( $this.form_query[field] ) != 'undefined' && $this.form_query[field] == 'on' )
			{
				sum += parseFloat( values[field] );
			}
		}
		// ==============================================================
		// Simple inputs
		// ==============================================================
		for( var i = 0; i < input_fields.length; i++ )
		{
			field = input_fields[i];
			sum += values[field] * parseInt( $this.form_query[field] );
		}
		// ==============================================================
		// Inputs with relations to vehicle type
		// ==============================================================
		var scraping_corrosion = {
			0: values['passenger_cars'] * parseInt( $this.form_query['scraping_corrosion'] ),
			1: values['suv'] * parseInt( $this.form_query['scraping_corrosion'] )
		};
		var finish_balancing_front_axle = {
			0: values['pc_front_axle']  * parseInt( $this.form_query['finish_balancing_front_axle'] ),
			1: values['oc_front_axle']  * parseInt( $this.form_query['finish_balancing_front_axle'] )
		};
		var finish_balancing_rear_axle = {
			0: values['pc_rear_axle']  * parseInt( $this.form_query['finish_balancing_rear_axle'] ),
			1: values['oc_rear_axle']  * parseInt( $this.form_query['finish_balancing_rear_axle'] )
		};

		sum += scraping_corrosion[vehicle_type] + finish_balancing_front_axle[vehicle_type] + finish_balancing_rear_axle[vehicle_type];
		
		return { title: 'Other service', sum: sum };
	};

	/**
	 * Calculate Polishing board section
	 * @param  json values --- values 
	 * @return json --- title, sum
	 */
	$this.calculatePolishingBoard = function(values){
		var count          = parseInt( $this.form_query['pb_number_of_discs'] );
		var polishing_type = $this.form_query['polishing_type'];
		var sum            = 0;

		if( typeof( polishing_type ) != 'undefined' )
		{
			sum = parseFloat( values[polishing_type] ) * count;
		}
		return { title: 'Polishing board', sum: sum };
	};

	/**
	 * Calculate Discs Painting section
	 * @param  json values --- values 
	 * @return json --- title, sum
	 */
	$this.calculateDiscsPainting = function(values){
		var count         = parseInt( $this.form_query['dp_number_of_discs'] );
		var painting_type = $this.form_query['painting_type'];
		var sum           = 0;

		if( typeof( painting_type ) != 'undefined' )
		{
			sum = parseFloat( values[painting_type] ) * count;
		}
		return { title: 'Discs painting', sum: sum };
	};

	/**
	 * Calculate Discs Repair section
	 * @param  json values --- values 
	 * @return json --- title, sum
	 */
	$this.calculateDiscsRepari = function(values){
		var count = parseInt( $this.form_query['dr_number_of_discs'] );
		var damage_type = $this.form_query['damage_type'];
		var sum = 0;

		if( typeof( damage_type ) != 'undefined' )
		{
			sum = parseFloat( values[damage_type] ) * count;
		}
		return { title: 'Discs repair', sum: sum };
	};

	/**
	 * Calculate Tire Service section
	 * @param  json values --- values 
	 * @return json --- title, sum
	 */
	$this.calculateTireService = function(values){
		var count  = parseInt( $this.form_query['ts_number_of_wheels'] );
		var fields = ['mounting_tyre', 'remove_instllation', 'removing_tyre', 'tire_balancing'];
		var field  = '';
		var sum    = 0;

		for (var i = 0; i < fields.length; i++) 
		{
			field = fields[i];
		
			if( typeof( $this.form_query[field] ) != 'undefined' && $this.form_query[field] == 'on' )
			{
				sum += count * parseFloat( values[field] );
			}
		}
		return { title: 'Tire service', sum: sum };
	};

	/**
	 * Get values from response
	 * @param  json fields --- query fields
	 * @param  json response --- query response
	 * @return json --- array with values
	 */
	$this.getValues = function(fields, response)
	{
		var id  = '';
		var key = '';
		var val = 0;

		for(key in fields)
		{
			id = fields[key].trim();
			if( typeof(response[id]) != 'undefined' )
			{
				val = parseFloat( response[id] );	
			}
			else
			{
				val = 0;
			}
			fields[key] = val;
		}
		return fields;
	}

	/**
	 * Get query json array from form
	 * @param  string form --- form selector
	 * @return json --- query
	 */
	$this.getQuery = function(form){
		var query  = jQuery(form).serializeArray();
		var result = {};
		for(var i = 0; i < query.length; i++)
		{
			result[query[i].name] = query[i].value;
		}
		return result;
	};

	/**
	 * Get all fields from sections
	 * @param  array query --- form query
	 * @return json --- fields
	 */
	$this.getFields = function(query){
		var result = {};

		result = $this.concat( result, $this.getFiledsTireService( query.vehicle_type, query.tyre_type ) );
		result = $this.concat( result, $this.getFieldsDiscsRepair( query.disc_type ) );
		result = $this.concat( result, $this.getFieldsDiscsPainting( query.disc_type ) );
		result = $this.concat( result, $this.getFieldsPolishingBoard() );
		result = $this.concat( result, $this.getFieldsOtherService() );
		
		return result;
	};

	/**
	 * Concat json array
	 * @param  json arr1 --- first array
	 * @param  json arr2 --- second array
	 * @return json --- concated array
	 */
	$this.concat = function(arr1, arr2){
		for( var key in arr2 )
		{
			arr1[key] = arr2[key];
		}
		return arr1;
	};

	/**
	 * Get fields Other service section
	 * @return json --- fields
	 */
	$this.getFieldsOtherService = function(){
		return {
			storage: 'f25',
			refill:  'f26'
		};
	};	

	/**
	 * Get fields Polishing board section
	 * @return json --- fields
	 */
	$this.getFieldsPolishingBoard = function(){
		return {
			narrow_board: 'f23',
			wide_board: 'f24'
		};
	};	

	/**
	 * Get fields Discs painting section
	 * @param  integer disc_type --- disc type
	 * @return json --- fields
	 */
	$this.getFieldsDiscsPainting = function(disc_type){
		var data = {
			0:{
				full_painting:   'f13',
				paint_the_front: 'f14'
			},
			1:{
				full_painting:   'f15',
				paint_the_front: 'f16'
			}
		};
		return data[disc_type];
	};	

	/**
	 * Get fields Discs repair section
	 * @param  integer disc_type --- disc type
	 * @return json --- fields
	 */
	$this.getFieldsDiscsRepair = function(disc_type){
		var data = {
			0:{
				radial_ronout:      'f17',
				axial_displacement: 'f18',
				rr_and_ad:          'f19'
			},
			1:{
				radial_ronout:      'f20',
				axial_displacement: 'f21',
				rr_and_ad:          'f22'
			}
		};
		return data[disc_type];
	};

	/**
	 * Get fields Tire Service section
	 * @param  integer vehicle_type --- vehicle type
	 * @return json --- fields
	 */
	$this.getFiledsTireService = function(vehicle_type, tyre_type){
		var runflat = (typeof(tyre_type) != 'undefined') ? 1:0;
		var data = {
			0: {
				0:{
					remove_instllation: 'f1',
					removing_tyre:      'f2',
					mounting_tyre:      'f3',
					tire_balancing:     'f6'
				},
				1:{
					remove_instllation: 'f1',
					removing_tyre:      'f4',
					mounting_tyre:      'f5',
					tire_balancing:     'f6'
				}
				
			},
			1: {
				0:{
					remove_instllation: 'f7',
					removing_tyre:      'f8',
					mounting_tyre:      'f9',
					tire_balancing:     'f12'
				},
				1:{
					remove_instllation: 'f7',
					removing_tyre:      'f10',
					mounting_tyre:      'f11',
					tire_balancing:     'f12'
				}
				
			}
		};
		return data[vehicle_type][runflat];
	};
}

jQuery(document).ready(function(){
	jQuery('#calculator').submit(function(event){
		cost_calculator = new CostCalculator();
		cost_calculator.calculate();
		event.preventDefault();
	});
});