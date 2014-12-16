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
$r1             = $GLOBALS['shop_page']->type;

extract($options_obj->options);
get_header();

?>

<div id="content_wrap">   
    <div class="row">
        <div id="content_full" class="editable span12 center none">            
            <form action="<?php echo get_permalink(); ?>" method="get" class="controls-block">
			<div class="search_title">Find Your Wheels & Tires</div>
                <input type="hidden" name="action" value="resultsToDisplay">
                <section class="radio">
                    <div class="row-fluid">
                        <div class="span6">                           
                            <input type="radio" name="r1" id="r1-tires" value="tires" <?php echo $options_obj->checked($r1 == 'tires' || $r1 == 'tires_in_detail'); ?>>
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
                            <div class="row-fluid" id="autoMake-row">
                                <div class="span4">
                                    <label for="autoMake"><?php _e('Select make'); ?>:</label>
                                </div>
                                <div class="span8" onclick="">
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
                                    echo $GLOBALS['shop_page']->getSelectControl('autoMake', $auto_make_values, $autoMake, '<option  selected="" value="">Select Make</option>');
                                    ?>
                                      
                                </div>
                            </div>
                            <!-- Select make end -->
                            <!-- Year -->

							
                            <div class="row-fluid" id="autoYear-row">
                                <div class="span4">
                                    <label for="autoYear"><?php _e('Year'); ?>:</label>
                                </div>
                                <div class="span8">
                                    <?php 
                                        $auto_year_prepend = '<option value="">Select year</option>';                                        
                                        echo $GLOBALS['shop_page']->getSelectControl('autoYear', array(), '', $auto_year_prepend); 
                                    ?>                                  
                                </div>
                            </div>
                            <!-- Year end -->
                        </div>
                        <div class="span5">
                            <!-- Model-->
                            <div class="row-fluid" id="autoModel-row">
                                <div class="span4">
                                    <label for="autoModel"><?php _e('Model'); ?>:</label>
                                </div>
                                <div class="span8">
                                    <?php 
                                        $auto_model_prepend = '<option value="">Select model</option>';                                        
                                        echo $GLOBALS['shop_page']->getSelectControl('autoModel', array(), '', $auto_model_prepend); 
                                    ?>       
                                </div>
                            </div>
                            <!-- Model end -->

                            <!-- Additional -->
                            <div class="row-fluid" id="autoModClar-row">
                                <div class="span4">
                                    <label for="autoModClar"><?php _e('Additional'); ?>:</label>
                                </div>
                                <div class="span8">
                                    <?php 
                                        $auto_modclar_prepend = '<option value="">Additional Model Info</option>';                                        
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
			
			 <img style="float:left;" src="<?php echo TDU.'/images/cart.png'; ?>" alt="Cart" class="cart-icon">
              <?php /*  <div class="titles">
                    <span class="title">Cart:</span>
                    <span class="count">4 items</span>    
                </div>
                 <button type="button" class="btn-orange"><b class="right-caret"></b></button>
            */?>
			<?php echo do_shortcode('[wp_compact_cart]'); ?>	
               
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
        <div class="total">Set of <span class="count">0</span>: <span class="red price">$0.00</span><div class="add-button"></div></div>
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
                <li class="front"><img src="/images/wheelrack/wheel_images/Advanti_Racing/15_Anniversary.Q.20.gif" alt=""></li>
                <li class="rear"><img src="/images/wheelrack/wheel_images/Advanti_Racing/15_Anniversary.Q.20.gif" alt=""></li>
            </ul>
        </div>
        <div class="paste-table">
           Empty
        </div>        
    </div>
</div>
<!-- /#view-on-vehicle-modal -->


<div id="tire-modal" class="modal" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" >&times;</button>
        <div class="title"><h3></h3></div>
    </div>
    
    <div class="modal-body">
        <div class="image-block">
            <img id="large-image" src="/images/tires/bridgestone/bs_potenza_re050a_II_ci2_l.jpg" alt="">
            <div class="separator-text">
                Sidewall Style: <span>empty</span>
            </div>
            <ul class="small-images">
                <li><a href="#" data-large="/images/tires/bridgestone/bs_potenza_re050a_II_ci2_l.jpg"><img src="/images/tires/bridgestone/bs_potenza_re050a_II_ci2_s.jpg" alt=""></a></li>
                <li><a href="#" data-large="/images/tires/bridgestone/bs_potenza_re050a_II_ci1_l.jpg"><img src="/images/tires/bridgestone/bs_potenza_re050a_II_ci1_s.jpg" alt=""></a></li>
                <li><a href="#" data-large="/images/tires/bridgestone/bs_potenza_re050a_II_ci3_l.jpg"><img src="/images/tires/bridgestone/bs_potenza_re050a_II_ci3_s.jpg" alt=""></a></li>
            </ul>
            <div class="separator-text-light">Click thumbnails to view above.</div>
            <div class="separator-text-dark"><a href="#">View Full Screen Photo.</a></div>
        </div>    
        <div class="tabs-wrap">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#description" id="description-tab">Product Description</a></li>
                <li><a href="#surveys" id="surveys-tab">Surveys</a></li>        
            </ul>
            <div class="tab-content">
                        <div class="tab-pane active" id="description">
                            <div id="englishCopy" style="display:block;">
                                <p>
                                    The Potenza RE050 is an Ultra High Performance Summer tire designed to complement the performance of sports cars, sports coupes and sport sedans. While the Potenza RE050 is used as Original Equipment on the supercharged Mercedes-Benz S55 AMG sedan, a Potenza RE050 Scuderia version is used on the 12-cylinder Enzo Ferrari supercar. The Potenza RE050 was developed to provide good traction along with responsive and predictable dry and wet road handling. It is not intended to be driven in near-freezing temperatures, through snow or on ice.
                                </p>
                                <p>
                                    The Potenza RE050 features a high-grip tread compound molded into a directional tread design. A continuous center rib, large tread blocks and stable shoulder elements provide responsive handling, high-speed stability and traction on dry roads, while circumferential and lateral tread grooves are aimed to pump water out from under the tire's footprint to minimize hydroplaning and aid wet traction. The tire's internal structure includes twin steel belts reinforced by spiral-wrapped nylon to stabilize the tread area and enhance handling, high speed capability and ride quality. The fabric cord body and hard rubber sidewall filler helps blend uniform ride quality with steering response and lateral stability.
                                </p>

                            </div>
                        </div>
                        <div class="tab-pane" id="surveys">
                            <table class="surveyresults" border="0" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                        <td>

                                            <p class="csr">
                                                Results based on 229 submissions of our
                                                <a href="/tires/surveyresults/index.jsp">online tire survey</a>
                                                .
                                            </p>
                                        </td>
                                        <td colspan="15">
                                            <img src="/images/reviews/SurveyTabs.gif" alt="Survey Tabs" height="99" width="572"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Surveyed Averages</td>
                                        <td width="26" align="center">26</td>
                                        <td width="26" align="center">79%</td>
                                        <td class="good" width="26" align="center">5.2</td>
                                        <td class="excellent" width="26" align="center">7.1</td>
                                        <td class="excellent" width="26" align="center">7.3</td>
                                        <td class="excellent" width="26" align="center">8.3</td>
                                        <td class="excellent" width="26" align="center">8.5</td>
                                        <td class="excellent" width="26" align="center">8.5</td>
                                        <td class="notavail" width="26" align="center">N/A</td>
                                        <td class="notavail" width="26" align="center">N/A</td>
                                        <td class="notavail" width="26" align="center">N/A</td>
                                        <td class="excellent" width="26" align="center">6.9</td>
                                        <td class="good" width="26" align="center">6.2</td>
                                        <td class="good" width="26" align="center">5.5</td>
                                        <td width="54" align="right">3,414,077</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="surveykey" width="283" border="0" cellspacing="0" cellpadding="3" align="right">
                                <thead>
                                    <tr>
                                        <td colspan="2">Color Key</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="superior">
                                                <br></div> <strong>Superior</strong>
                                            (8.6-10)
                                        </td>
                                        <td>
                                            <div class="fair">
                                                <br></div> <strong>Fair</strong>
                                            (2.6-4.5)
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="excellent">
                                                <br></div>
                                            <strong>Excellent</strong>
                                            (6.6-8.5)
                                        </td>
                                        <td>
                                            <div class="unacceptable">
                                                <br></div>
                                            <strong>Unacceptable</strong>
                                            (0-2.5)
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="good">
                                                <br></div>
                                            <strong>Good</strong>
                                            (4.6-6.5)
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>
                                <strong>Would You Buy This Tire Again?</strong>
                                <br>Most said: "Possibly" (Average of 5.2 out of 10)</p>
                            <p>
                                <strong>How Did This Tire Rank In Its Category?</strong>
                                <br>
                                26 out of 26 tires (Score of 7.3 vs best tire in category score of 9.1)
                            </p>
                            <p>

                                <a href="/tires/surveyresults/surveydisplay.jsp?type=MP">
                                    See a Full List of Survey Results for Max Performance Summer Tires
                                </a>

                            </p>
                        </div>            
                    </div>
        </div>
    </div>
</div>
<!-- /#tire-modal -->
<?php get_footer(); ?>