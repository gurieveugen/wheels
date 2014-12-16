<?php
/**
 * Template name: Calculator
 */

require_once 'includes/CostCalculatorHTML.php';

$cost_calculator_html = new CostCalculatorHTML();
$top_scripts = nimbus_get_option('top_scripts_multi');
$bottom_scripts = nimbus_get_option('bottom_scripts_multi');
get_header();
the_post();
?>

<div id="content_wrap">
    <div class="row">
        <div id="content_full" class="span12 center none">
        	<?php
        	if (get_post_meta($post->ID, 'include_image_on_page', true) == "true") 
        	{
        		if (has_post_thumbnail()) 
        		{
                    the_post_thumbnail('nimbus-post-full', array('class' => 'page_image'));
				}
        	}
        	if ($top_scripts['page'] = 1) 
        	{
                nimbus_scripts_content_top();
            }
            the_content();
            wp_link_pages();
            if ($bottom_scripts['page'] = 1) 
            {
				nimbus_scripts_content_bottom();
			}

        	?>
        	<div class="products">
        		<div class="products-inner">
        			<?php echo $cost_calculator_html->getHTML(); ?>
        		</div>
        	</div>
        	
            <div class="clear"></div>			

        </div>
    </div>
</div>



<?php get_footer(); ?>