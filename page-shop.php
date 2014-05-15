<?php
/**
 * Template name: Shop
 */
?>

<?php
$top_scripts = nimbus_get_option('top_scripts_multi');
$bottom_scripts = nimbus_get_option('bottom_scripts_multi');
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
                            <input type="radio" name="r1" id="r1-tires" value="tires" checked>
                            <label for="r1-tires">
                                <img src="<?php echo TDU.'/images/tires.png'; ?>" alt="">        
                                Tires
                            </label>
                        </div>
                        <div class="span6">
                            <input type="radio" name="r1" id="r1-wheels" value="wheels">
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
                                    <select name="autoMake" id="autoMake">
                                        <option selected="" value="">Select Make</option>
                                        <option value="Acura">Acura</option>
                                        <option value="Alfa">Alfa</option>
                                        <option value="American Motors">American Motors</option>
                                        <option value="Aston Martin">Aston Martin</option>
                                        <option value="Audi">Audi</option>
                                        <option value="BMW">BMW</option>
                                        <option value="Bentley">Bentley</option>
                                        <option value="Buick">Buick</option>
                                        <option value="Cadillac">Cadillac</option>
                                        <option value="Chevrolet">Chevrolet</option>
                                        <option value="Chrysler">Chrysler</option>
                                        <option value="Daewoo">Daewoo</option>
                                        <option value="Daihatsu">Daihatsu</option>
                                        <option value="Datsun">Datsun</option>
                                        <option value="Delorean">Delorean</option>
                                        <option value="Dodge">Dodge</option>
                                        <option value="Eagle">Eagle</option>
                                        <option value="Ferrari">Ferrari</option>
                                        <option value="Fiat">Fiat</option>
                                        <option value="Ford">Ford</option>
                                        <option value="Freightliner">Freightliner</option>
                                        <option value="GMC">GMC</option>
                                        <option value="Geo">Geo</option>
                                        <option value="Honda">Honda</option>
                                        <option value="Hummer">Hummer</option>
                                        <option value="Hyundai">Hyundai</option>
                                        <option value="Infiniti">Infiniti</option>
                                        <option value="Isuzu">Isuzu</option>
                                        <option value="Jaguar">Jaguar</option>
                                        <option value="Jeep">Jeep</option>
                                        <option value="Kia">Kia</option>
                                        <option value="Lamborghini">Lamborghini</option>
                                        <option value="Lancia">Lancia</option>
                                        <option value="Land Rover">Land Rover</option>
                                        <option value="Lexus">Lexus</option>
                                        <option value="Lincoln">Lincoln</option>
                                        <option value="Lotus">Lotus</option>
                                        <option value="MG">MG</option>
                                        <option value="Maserati">Maserati</option>
                                        <option value="Maybach">Maybach</option>
                                        <option value="Mazda">Mazda</option>
                                        <option value="Mercedes-Benz">Mercedes-Benz</option>
                                        <option value="Mercury">Mercury</option>
                                        <option value="Merkur">Merkur</option>
                                        <option value="Mini">Mini</option>
                                        <option value="Mitsubishi">Mitsubishi</option>
                                        <option value="Mosler">Mosler</option>
                                        <option value="Nissan">Nissan</option>
                                        <option value="Noble">Noble</option>
                                        <option value="Oldsmobile">Oldsmobile</option>
                                        <option value="Opel">Opel</option>
                                        <option value="Panoz">Panoz</option>
                                        <option value="Peugeot">Peugeot</option>
                                        <option value="Pininfarina">Pininfarina</option>
                                        <option value="Plymouth">Plymouth</option>
                                        <option value="Pontiac">Pontiac</option>
                                        <option value="Porsche">Porsche</option>
                                        <option value="Renault">Renault</option>
                                        <option value="Ram">Ram</option>
                                        <option value="Rolls Royce">Rolls Royce</option>
                                        <option value="Roush">Roush</option>
                                        <option value="Saab">Saab</option>
                                        <option value="Saleen">Saleen</option>
                                        <option value="Saturn">Saturn</option>
                                        <option value="Scion">Scion</option>
                                        <option value="Shelby">Shelby</option>
                                        <option value="Shelby Super Car">Shelby Super Car</option>
                                        <option value="smart">smart</option>
                                        <option value="Spyker">Spyker</option>
                                        <option value="SRT">SRT</option>
                                        <option value="Sterling">Sterling</option>
                                        <option value="Subaru">Subaru</option>
                                        <option value="Suzuki">Suzuki</option>
                                        <option value="Tesla">Tesla</option>
                                        <option value="Toyota">Toyota</option>
                                        <option value="Triumph">Triumph</option>
                                        <option value="Volkswagen">Volkswagen</option>
                                        <option value="Volvo">Volvo</option>
                                    </select>    
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
                                        $years = array('Select make'); 
                                        echo $GLOBALS['shop']->getSelectControl('autoYear', $years); 
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
                                        $years = array('Select year'); 
                                        echo $GLOBALS['shop']->getSelectControl('autoModel', $years); 
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
                                        $years = array('Select model'); 
                                        echo $GLOBALS['shop']->getSelectControl('autoModClar', $years); 
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
                <div class="left-content">
                    
                    <div class="filter-title">
                        <span>FILTER BY</span>
                        <a href="#">(Reset Filters)</a>
                    </div>
                    <!-- /.filter-title -->

                   <div class="accordion">
                       <div class="accordion-group">
                           <div class="accordion-heading">
                               <a href="#collapseOne" class="accordion-toggle"><b class="down-caret"></b>Diameter</a>
                           </div>
                           <div class="accordion-body in collapse" id="collapseOne">
                               <div class="accordion-inner">
                                    <select name="additional" id="additional">
                                        <option value="audi">Audi</option>
                                        <option value="audi2">Audi2</option>
                                    </select>    
                               </div>
                           </div>
                       </div>
                       <div class="accordion-group">
                           <div class="accordion-heading">
                               <a href="#collapseTwo" class="accordion-toggle"><b class="down-caret"></b>Finish</a>
                           </div>
                           <div class="accordion-body in collapse" id="collapseTwo">
                               <div class="accordion-inner">
                                    <select name="additional" id="additional">
                                        <option value="audi">Audi</option>
                                        <option value="audi2">Audi2</option>
                                    </select>    
                               </div>
                           </div>
                       </div>
                       <div class="accordion-group">
                           <div class="accordion-heading">
                               <a href="#collapseThree" class="accordion-toggle"><b class="down-caret"></b>Brand</a>
                           </div>
                           <div class="accordion-body in collapse" id="collapseThree">
                               <div class="accordion-inner">
                                    <select name="additional" id="additional">
                                        <option value="audi">Audi</option>
                                        <option value="audi2">Audi2</option>
                                    </select>    
                               </div>
                           </div>
                       </div>
                       <div class="accordion-group">
                           <div class="accordion-heading">
                               <a href="#collapseFour" class="accordion-toggle"><b class="down-caret"></b>Weight</a>
                           </div>
                           <div class="accordion-body in collapse" id="collapseFour">
                               <div class="accordion-inner">
                                    <select name="additional" id="additional">
                                        <option value="audi">Audi</option>
                                        <option value="audi2">Audi2</option>
                                    </select>    
                               </div>
                           </div>
                       </div>
                   </div>
                   <!-- /.accordion -->

                </div>
                <!-- /.left-content -->

                <div class="right-content">
                    <table class="main-table">
                        <tbody>
                            <?php 
                                $items = $GLOBALS['shop']->getResults();
                                echo $GLOBALS['shop']->wrapItems($items);
                            ?>
                        </tbody>
                    </table>
                    <!-- <table class="main-table">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="left-side">
                                        <div class="image">
                                            <a href="#"><img src="<?php echo TDU; ?>/images/test1.jpg" alt=""></a>    
                                        </div>   
                                        <ul class="links">
                                            <li><a href="#">18" <br> 204</a></li>
                                            <li><a href="#">20" <br> 249</a></li>
                                        </ul> 
                                    </div>
                                    <div class="right-side">
                                        <div class="image">
                                            <a href="#"><img src="<?php echo TDU; ?>/images/test1.gif" alt=""></a>                                                
                                        </div>
                                        <a href="#" class="link">Advanti Racing 15 Anniversary</a><br><br>
                                        <span class="description">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus, autem.
                                        </span><br>
                                        <a href="#" class="link"><b>View on Vehicle</b></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="left-side">
                                        <div class="image">
                                            <a href="#"><img src="<?php echo TDU; ?>/images/test2.jpg" alt=""></a>    
                                        </div>                                        
                                        <ul class="links">
                                            <li><a href="#">18" <br> 204</a></li>
                                            <li><a href="#">20" <br> 249</a></li>
                                        </ul> 
                                    </div>
                                    <div class="right-side">
                                        <div class="image">
                                            <a href="#"><img src="<?php echo TDU; ?>/images/test1.gif" alt=""></a>                                                
                                        </div>
                                        <a href="#" class="link">Advanti Racing 15 Anniversary</a><br><br>
                                        <span class="description">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus, autem.
                                        </span><br>
                                        <a href="#" class="link"><b>View on Vehicle</b></a>
                                    </div>
                                </td>
                            </tr>

                             <tr>
                                <td>
                                    <div class="left-side">
                                        <div class="image">
                                            <a href="#"><img src="<?php echo TDU; ?>/images/test1.jpg" alt=""></a>    
                                        </div>   
                                        <ul class="links">
                                            <li><a href="#">18" <br> 204</a></li>
                                            <li><a href="#">20" <br> 249</a></li>
                                        </ul> 
                                    </div>
                                    <div class="right-side">
                                        <div class="image">
                                            <a href="#"><img src="<?php echo TDU; ?>/images/test1.gif" alt=""></a>                                                
                                        </div>
                                        <a href="#" class="link">Advanti Racing 15 Anniversary</a><br><br>
                                        <span class="description">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus, autem.
                                        </span><br>
                                        <a href="#" class="link"><b>View on Vehicle</b></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="left-side">
                                        <div class="image">
                                            <a href="#"><img src="<?php echo TDU; ?>/images/test2.jpg" alt=""></a>    
                                        </div>                                        
                                        <ul class="links">
                                            <li><a href="#">18" <br> 204</a></li>
                                            <li><a href="#">20" <br> 249</a></li>
                                        </ul> 
                                    </div>
                                    <div class="right-side">
                                        <div class="image">
                                            <a href="#"><img src="<?php echo TDU; ?>/images/test1.gif" alt=""></a>                                                
                                        </div>
                                        <a href="#" class="link">Advanti Racing 15 Anniversary</a><br><br>
                                        <span class="description">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus, autem.
                                        </span><br>
                                        <a href="#" class="link"><b>View on Vehicle</b></a>
                                    </div>
                                </td>
                            </tr>

                             <tr>
                                <td>
                                    <div class="left-side">
                                        <div class="image">
                                            <a href="#"><img src="<?php echo TDU; ?>/images/test1.jpg" alt=""></a>    
                                        </div>   
                                        <ul class="links">
                                            <li><a href="#">18" <br> 204</a></li>
                                            <li><a href="#">20" <br> 249</a></li>
                                        </ul> 
                                    </div>
                                    <div class="right-side">
                                        <div class="image">
                                            <a href="#"><img src="<?php echo TDU; ?>/images/test1.gif" alt=""></a>                                                
                                        </div>
                                        <a href="#" class="link">Advanti Racing 15 Anniversary</a><br><br>
                                        <span class="description">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus, autem.
                                        </span><br>
                                        <a href="#" class="link"><b>View on Vehicle</b></a>
                                    </div>
                                </td>
                                <td>
                                    <div class="left-side">
                                        <div class="image">
                                            <a href="#"><img src="<?php echo TDU; ?>/images/test2.jpg" alt=""></a>    
                                        </div>                                        
                                        <ul class="links">
                                            <li><a href="#">18" <br> 204</a></li>
                                            <li><a href="#">20" <br> 249</a></li>
                                        </ul> 
                                    </div>
                                    <div class="right-side">
                                        <div class="image">
                                            <a href="#"><img src="<?php echo TDU; ?>/images/test1.gif" alt=""></a>                                                
                                        </div>
                                        <a href="#" class="link">Advanti Racing 15 Anniversary</a><br><br>
                                        <span class="description">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus, autem.
                                        </span><br>
                                        <a href="#" class="link"><b>View on Vehicle</b></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>   -->
                    <!-- /.main-table -->
                    <div class="footer">
                        <a href="#" class="link"><b>View all 266 wheels</b></a> | <label for="select-page">View per Page:</label>
                        <select name="page" id="select-page">
                            <option value="12">12</option>
                        </select>
                        |
                        <a href="#" class="left-arrow"></a>
                        <ul class="pages">
                            <li><b>1</b></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">6</a></li>
                            <li><a href="#">7</a></li>
                            <li><a href="#">8</a></li>
                            <li><a href="#">9</a></li>
                            <li><a href="#">10</a></li>
                            <li><a href="#">...</a></li>
                        </ul>
                        <a href="#" class="right-arrow"></a>
                    </div>
                </div>       
                <!-- /.right-content -->
                
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>