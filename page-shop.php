<?php
/**
 * Template name: Shop
 */
?>

<?php
require_once 'includes/options.php';

$top_scripts    = nimbus_get_option('top_scripts_multi');
$bottom_scripts = nimbus_get_option('bottom_scripts_multi');
$options_obj    = new Options($_GET);
$items          = $GLOBALS['shop_page']->getResults();
extract($options_obj->options);

get_header();

?>

<div id="content_wrap">   
    <div class="row">
        <div id="content_full" class="editable span12 center none">            
            <form action="<?php echo get_permalink(); ?>" method="get" class="controls-block">
                <input type="hidden" name="action" value="resultsToDisplay">
                <section class="radio">
                    <div class="row-fluid">
                        <div class="span6">
                            <input type="radio" name="r1" id="r1-tires" value="tires" <?php echo $options_obj->checked($r1 == 'tires'); ?>>
                            <label for="r1-tires">
                                <img src="<?php echo TDU.'/images/tires.png'; ?>" alt="">        
                                Tires
                            </label>
                        </div>
                        <div class="span6">
                            <input type="radio" name="r1" id="r1-wheels" value="wheels"  <?php echo $options_obj->checked($r1 == 'wheels'); ?>>
                            <label for="r1-wheels">
                                <img src="<?php echo TDU.'/images/wheels.png'; ?>" alt="">        
                                Wheels
                            </label>
                        </div>
                    </div>
                </section>
                <section class="selects">
                    <div class="row-fluid">
                        <div class="span5">
                            <!-- Select make -->
                            <div class="row-fluid">
                                <div class="span4">
                                    <label for="autoMake"><?php _e('Select make'); ?>:</label>
                                </div>
                                <div class="span8">
                                    <?php
                                    $auto_make_values = array(
                                        'Acura', 'Alfa', 'American Motors', 'Aston Martin', 'Audi', 
                                        'BMW', 'Bentley', 'Buick', 'Cadillac', 'Chevrolet', 
                                        'Chrysler', 'Daewoo', 'Daihatsu', 'Datsun', 'Delorean', 
                                        'Dodge', 'Eagle', 'Ferrari', 'Fiat', 'Ford', 
                                        'Freightliner', 'GMC', 'Geo', 'Honda', 'Hummer', 
                                        'Hyundai', 'Infiniti', 'Isuzu', 'Jaguar', 'Jeep', 
                                        'Kia', 'Lamborghini', 'Lancia', 'Land Rover', 'Lexus', 
                                        'Lincoln', 'Lotus', 'MG', 'Maserati', 'Maybach', 
                                        'Mazda', 'Mercedes-Benz', 'Mercury', 'Merkur', 'Mini', 
                                        'Mitsubishi', 'Mosler', 'Nissan', 'Noble', 'Oldsmobile', 
                                        'Opel', 'Panoz', 'Peugeot', 'Pininfarina', 'Plymouth', 
                                        'Pontiac', 'Porsche', 'Renault', 'Ram', 'Rolls Royce', 
                                        'Roush', 'Saab', 'Saleen', 'Saturn', 'Scion', 
                                        'Shelby', 'Shelby Super Car', 'smart', 'Spyker', 'SRT', 
                                        'Sterling', 'Subaru', 'Suzuki', 'Tesla', 'Toyota', 
                                        'Triumph', 'Volkswagen', 'Volvo');
                                    echo $GLOBALS['shop_page']->getSelectControl('autoMake', $auto_make_values, $autoMake, '<option selected="" value="">Select Make</option>');
                                    ?>
                                      
                                </div>
                            </div>
                            <!-- Select make end -->
                            <!-- Year -->
                            <div class="row-fluid">
                                <div class="span4">
                                    <label for="autoYear"><?php _e('Year'); ?>:</label>
                                </div>
                                <div class="span8">
                                    <?php 
                                        $auto_year_prepend = $autoYear ? sprintf('<option value="%1$s" selected>%1$s</option>', $autoYear) : '<option value="">Select make</option>';                                        
                                        echo $GLOBALS['shop_page']->getSelectControl('autoYear', array(), '', $auto_year_prepend); 
                                    ?>                                  
                                </div>
                            </div>
                            <!-- Year end -->
                        </div>
                        <div class="span5">
                            <!-- Model-->
                            <div class="row-fluid">
                                <div class="span4">
                                    <label for="autoModel"><?php _e('Model'); ?>:</label>
                                </div>
                                <div class="span8">
                                    <?php 
                                        $auto_model_prepend = $autoModel ? sprintf('<option value="%1$s" selected>%1$s</option>', $autoModel) : '<option value="">Select year</option>';                                        
                                        echo $GLOBALS['shop_page']->getSelectControl('autoModel', array(), '', $auto_model_prepend); 
                                    ?>       
                                </div>
                            </div>
                            <!-- Model end -->

                            <!-- Additional -->
                            <div class="row-fluid">
                                <div class="span4">
                                    <label for="autoModClar"><?php _e('Additional'); ?>:</label>
                                </div>
                                <div class="span8">
                                    <?php 
                                        $auto_modclar_prepend = $autoModClar ? sprintf('<option value="%1$s" selected>%1$s</option>', $autoModClar) : '<option value="">Select model</option>';                                        
                                        echo $GLOBALS['shop_page']->getSelectControl('autoModClar', array(), '', $auto_modclar_prepend); 
                                    ?> 
                                </div>
                            </div>
                            <!-- Additional end -->
                        </div>
                        <div class="span2">
                            <button type="submit" class="btn-orange">Search</button>
                        </div>
                    </div>
                </section>
            </form><!-- /.controls-block -->
            <!-- cart-block -->
            <div class="cart-block">
                <img src="<?php echo TDU.'/images/cart.png'; ?>" alt="Cart" class="cart-icon">
                <div class="titles">
                    <span class="title">Cart:</span>
                    <span class="count">4 items</span>    
                </div>
                
                <button type="button" class="btn-orange"><b class="right-caret"></b></button>
            </div>
            <!-- /.cart-block -->
            <div class="clear"></div>       

            <div class="products">                
                <?php echo $GLOBALS['shop_page']->getSidebar($items); ?>
                <div class="right-content">
                    <?php echo $GLOBALS['shop_page']->getPagination($items); ?>
                    <table class="main-table">
                        <?php echo $GLOBALS['shop_page']->getTableHead(); ?>
                        <tbody>
                            <?php echo $GLOBALS['shop_page']->wrapItems($items); ?>
                        </tbody>
                    </table>                    
                </div>       
                <!-- /.right-content -->
                
            </div>
        </div>
    </div>
</div>
<div id="product-modal" class="modal" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" >&times;</button>
        <div class="total">Set of <span class="count">0</span>: <span class="red price">$0.00</span></div>
  </div>
  <div class="img-lg">
    <img src="http://placehold.it/400x400" alt="">    
  </div>
  <div class="modal-body">
    
  </div>
</div>
<!-- /#product-modal -->

<div id="view-on-vehicle-modal" class="modal" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" >&times;</button>
        <h3>Empty</h3>
        <div class="paste-select">
            <select name="changeColor" onchange="changeVehicleColor();" id="WSLchangeColor">
                <option>Empty</option>                
            </select>    
        </div>
        
    </div> 
    <div class="modal-body">        
        <div class="car">
            <img class="car-img" src="/images/wheelrack/car_images/BMW/328i_Coupe_08/328i.18.Alpine_White.gif" alt="car">    
            <ul class="wheels">
                <li class="left"><img src="/images/wheelrack/wheel_images/Advanti_Racing/15_Anniversary.Q.20.gif" alt=""></li>
                <li class="right"><img src="/images/wheelrack/wheel_images/Advanti_Racing/15_Anniversary.Q.20.gif" alt=""></li>
            </ul>
        </div>
        <div class="paste-table">
           Empty
        </div>        
    </div>
</div>
<!-- /#view-on-vehicle-modal -->
<?php get_footer(); ?>