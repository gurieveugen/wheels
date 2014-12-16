<?php

class CostCalculator{
	//                                       __  _          
	//     ____  _________  ____  ___  _____/ /_(_)__  _____
	//    / __ \/ ___/ __ \/ __ \/ _ \/ ___/ __/ / _ \/ ___/
	//   / /_/ / /  / /_/ / /_/ /  __/ /  / /_/ /  __(__  ) 
	//  / .___/_/   \____/ .___/\___/_/   \__/_/\___/____/  
	// /_/              /_/                                 
	private $cc_prices;
	private $cc_global;
	private $cc_balancing;
	private $s_global;
	private $s_balancing;
	private $pt_calc;
	private $p_calc;
	private $mb_prices;
	private $t_vehicle_type;
	private $fields;
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	public function __construct()
	{
		// ==============================================================
		// Actions 
		// ==============================================================
		add_action( 'admin_enqueue_scripts', array(&$this, 'adminScriptsAndStyles') );
		add_action( 'wp_enqueue_scripts', array(&$this, 'wpScriptsAndStyles') );
		add_action( 'wp_ajax_calculate', array( &$this, 'calculateAJAX' ) );

		$this->fields = array(
			array( 'value' => 'f1', 'label' => 'Passenger cars - Removal \ Installation '),
			array( 'value' => 'f2', 'label' => 'Passenger cars - Removing Tyre '),
			array( 'value' => 'f3', 'label' => 'Passenger cars - Mounting Tyre '),
			array( 'value' => 'f4', 'label' => 'Passenger cars - Removing Tyre - Runflat '),
			array( 'value' => 'f5', 'label' => 'Passenger cars - Mounting Tyre - Runflat '),
			array( 'value' => 'f6', 'label' => 'Passenger cars - Tire balancing '),
			array( 'value' => 'f7', 'label' => 'Other cars - Removal \ Installation '),
			array( 'value' => 'f8', 'label' => 'Other cars - Removing Tyre '),
			array( 'value' => 'f9', 'label' => 'Other cars - Mounting Tyre  '),
			array( 'value' => 'f10', 'label' => 'Other cars - Removing Tyre - Runflat '),
			array( 'value' => 'f11', 'label' => 'Other cars - Mounting Tyre - Runflat '),
			array( 'value' => 'f12', 'label' => 'Other cars - Tire balancing '),
			array( 'value' => 'f13', 'label' => 'Alloy Wheels - Full painting '),
			array( 'value' => 'f14', 'label' => 'Alloy Wheels - Paint the front '),
			array( 'value' => 'f15', 'label' => 'Steel Wheels - Full painting '),
			array( 'value' => 'f16', 'label' => 'Steel Wheels - Paint the front '),
			array( 'value' => 'f17', 'label' => 'Repair alloy Wheels - Radial runout '),
			array( 'value' => 'f18', 'label' => 'Repair alloy Wheels - Axial displacement '),
			array( 'value' => 'f19', 'label' => 'Repair alloy Wheels - Radial runout and axial displacement '),
			array( 'value' => 'f20', 'label' => 'Repair steel Wheels - Passenger cars '),
			array( 'value' => 'f21', 'label' => 'Repair steel Wheels - Other cars '),
			array( 'value' => 'f22', 'label' => 'Repair steel Wheels - Radial runout and axial displacement '),
			array( 'value' => 'f23', 'label' => 'Narrow board '),
			array( 'value' => 'f24', 'label' => 'Wide board '),
			array( 'value' => 'f25', 'label' => 'Storage '),
			array( 'value' => 'f26', 'label' => 'Refill '),
			array( 'value' => 'f27', 'label' => 'Sandblasting discs '),
		);
	}	 

	/**
	 * Calculate [AJAX]
	 */
	public function calculateAJAX()
	{
		$json = array();

		if( isset( $_GET['size'] ) )
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
			    'include'           => array($_GET['size']),
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
			if( is_array($sizes) AND count($sizes) )
			{
				$size = $sizes[0];
				$args = array(
					'posts_per_page'   => -1,
					'offset'           => 0,
					'category'         => '',
					'category_name'    => '',
					'orderby'          => 'post_date',
					'order'            => 'DESC',
					'include'          => '',
					'exclude'          => '',
					'meta_key'         => '',
					'meta_value'       => '',
					'post_type'        => 'cost_calculator',
					'post_mime_type'   => '',
					'post_parent'      => '',
					'post_status'      => 'publish',
					'suppress_filters' => true,
					'tax_query'        => array(
						array(
							'taxonomy' => $size->taxonomy,
							'field'    => 'id',
							'terms'    => $size->term_id,
						)
					) 
				);
				$prices = get_posts( $args );
				$result = array();
				if(count($prices))
				{
					foreach ($prices as &$price) 
					{
						$result[$price->post_title] = get_post_meta( $price->ID, 'p_cost', true );
					}
				}
				$json = array_merge($json, $result);
			}
			
		}
		echo json_encode( $json );
		die();
	}

	/**
	 * Get options from DB
	 * @param  array $fields --- fields list
	 * @return array --- options $field => $value
	 */
	public static function getOptions($fields)
	{
		$result = array();
		foreach ($fields as $field) 
		{
			$result[$field] = (string) get_option( $field );
		}
		return $result;
	} 

	/**
	 * Add some scripts and styles to theme
	 */
	public function wpScriptsAndStyles()
	{
		// ==============================================================
		// Scripts
		// ==============================================================
		wp_enqueue_script( 'string-format', get_template_directory_uri().'/js/string.format.js' );
		wp_enqueue_script( 'calculator-print', get_template_directory_uri().'/js/calculator_print.js' );
		wp_enqueue_script( 
			'cost_calculator', 
			get_template_directory_uri().'/js/cost_calculator_theme.js', 
			array('jquery', 'string-format', 'calculator-print') 
		);
		wp_localize_script( 
			'cost_calculator',
			'cost_calculator_data',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'options'  => self::getOptions( 
					array(
						'gs_argon_welding', 'gs_processing_welding',
						'gs_passenger_cars', 'gs_suv',
						'gs_disposing_of_rubber', 'gs_solving_punctures_cameras',
						'gs_solving_punctures_tires', 'gs_technological_wheel_wash',
						'gs_valve_standart', 'gs_valve_chrome',
						'gs_spacer_rings', 'bp_pc_front_axle',
						'bp_pc_rear_axle', 'bp_oc_front_axle',
						'bp_oc_rear_axle',
					)
				)
			)
		);
	}

	/**
	 * Add some scipts and styles to admin panel
	 */
	public function adminScriptsAndStyles()
	{
		// ==============================================================
		// Scripts
		// ==============================================================
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 
			'cost_calculator', 
			get_template_directory_uri().'/js/cost_calculator.js', 
			array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget' ) 
		);
		wp_localize_script( 
			'cost_calculator', 
			'cost_calculator', 
			$this->fields 
		);

		// ==============================================================
		// Styles
		// ==============================================================
		wp_enqueue_style( 'cost_calculator', get_template_directory_uri().'/css/cost_calculator.css' );
	}

	/**
	 * Initialize ControlsCollections's
	 */
	private function initControlsCollection()
	{
		$this->cc_prices = new \Controls\ControlsCollection(
		    array(
		        new \Controls\Text(
		            'Cost',
		            array(
		                'description' => 'The cost of service',
		                'show_in_table' => true
		            )
		        )
		    )
		);

		$this->cc_global = new \Controls\ControlsCollection(
		    array(
		        new \Controls\Text(
		            'Argon welding',
		            array(
		                'description' => 'The cost of argon welding per 1 centimeter',
		                'show_in_table' => false
		            )
		        ),
		        new \Controls\Text(
		            'Processing welding',
		            array(
		                'description' => 'The cost of processing welding',
		                'show_in_table' => false
		            )
		        ),
		        new \Controls\Text(
		            'Scraping corrosion, primer coating ( passenger cars )',
		            array(
		                'description' => 'The cost of processing welding',
		                'show_in_table' => false
		            ),
		            array(
		            	'name' => 'passenger_cars'
		            )
		        ),
		        new \Controls\Text(
		            'Scraping corrosion, primer coating ( SUV )',
		            array(
		                'description' => 'Scraping seats from corrosion, coating the ground.',
		                'show_in_table' => false
		            ),
		            array(
		            	'name' => 'suv'
		            )
		        ),
		        new \Controls\Text(
		            'Disposing of rubber',
		            array(
		                'description' => 'Disposing of rubber.',
		                'show_in_table' => false
		            )
		        ),
		        new \Controls\Text(
		            'Solving punctures cameras',
		            array(
		                'description' => 'Solving punctures cameras.',
		                'show_in_table' => false
		            )
		        ),
		        new \Controls\Text(
		            'Solving punctures tires',
		            array(
		                'description' => 'Solving punctures tires.',
		                'show_in_table' => false
		            )
		        ),
		        new \Controls\Text(
		            'Technological wheel wash',
		            array(
		                'description' => 'Technological wheel wash.',
		                'show_in_table' => false
		            )
		        ),
		        new \Controls\Text(
		            'Replacing a valve ( standart )',
		            array(
		                'description' => 'Technological wheel wash.',
		                'show_in_table' => false
		            ),
		            array(
		            	'name' => 'valve_standart'
		            )
		        ),
		        new \Controls\Text(
		            'Replacing a valve ( chromium-plated )',
		            array(
		                'description' => 'Technological wheel wash.',
		                'show_in_table' => false
		            ),
		            array(
		            	'name' => 'valve_chrome'
		            )
		        ),
		        new \Controls\Text(
		            'Spacer rings',
		            array(
		                'description' => 'Technological wheel wash.',
		                'show_in_table' => false
		            )
		        )
		    )
		);

		$this->cc_balancing = new \Controls\ControlsCollection(
		    array(
		        new \Controls\Text(
		            'Passenger cars - Front axle',
		            array(
		                'description' => 'The cost of finish balancing front axle',
		                'show_in_table' => false
		            ),
		            array(
		            	'name' => 'pc_front_axle'
		            )
		        ),
		        new \Controls\Text(
		            'Passenger cars - Rear axle',
		            array(
		                'description' => 'The cost of finish balancing front axle',
		                'show_in_table' => false
		            ),
		            array(
		            	'name' => 'pc_rear_axle'
		            )
		        ),
		        new \Controls\Text(
		            'Other cars - Front axle',
		            array(
		                'description' => 'The cost of finish balancing front axle',
		                'show_in_table' => false
		            ),
		            array(
		            	'name' => 'oc_front_axle'
		            )
		        ),
		        new \Controls\Text(
		            'Other cars - Rear axle',
		            array(
		                'description' => 'The cost of finish balancing front axle',
		                'show_in_table' => false
		            ),
		            array(
		            	'name' => 'oc_rear_axle'
		            )
		        ),
		    )
		);
	}                                           

	/**
	 * Initialize Sections
	 */
	private function initSections()
	{
		$this->s_global    = new Admin\Section(
			'Global prices', 
			array(
				'prefix'   => 'gs_',
				'tab_icon' => 'fa-cog'
			), 
			$this->cc_global
		);

		$this->s_balancing    = new Admin\Section(
			'Balancing prices', 
			array(
				'prefix'   => 'bp_',
				'tab_icon' => 'fa-car'
			), 
			$this->cc_balancing
		);
	}

	/**
	 * Initialize PostType's
	 */
	private function initPostTypes()
	{
		$pt_calc = new \Admin\PostType(
		    'Cost calculator',
		    array( 
		        'supports' => array( 'title' ), 
		        'icon_code' => 'f1ec'
		    )
		);
	}

	/**
	 * Initialize page's
	 */
	private function initPages()
	{
		$this->p_calc = new \Admin\Page(
			'Global setting',
			array(
				'icon_code' => 'f1ec',
				'parent_page' => 'edit.php?post_type=cost_calculator'
			),
			array( $this->s_global, $this->s_balancing )
		);
	}

	/**
	 * Initialize MetaBoxe's
	 */
	private function initMetaBoxes()
	{
		$this->mb_prices = new \Admin\MetaBox(
		    'Base prices',
		    array(
		        'prefix' => 'p_',
		        'post_type' => 'cost_calculator'
		    ),
		    $this->cc_prices
		);
	}

	/**
	 * Initialize Taxonomie's
	 */
	private function initTaxonomies()
	{
		$this->t_vehicle_type = new \Admin\Taxonomy(
		    'Size',
		    array( 
		        'post_type' => 'cost_calculator'
		    )
		);
	}
	
	/**
	 * Initialize back - end: 
	 * Post types, Meta boxes, 
	 * Taxonomies, Sections, Pages
	 */
	public function initBackEnd()
	{
		$this->initControlsCollection();
		$this->initSections();
		$this->initPostTypes();
		$this->initPages();
		$this->initMetaBoxes();
		$this->initTaxonomies();
	}
}