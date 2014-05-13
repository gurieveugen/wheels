<div id="footer_wrap" class="row">

    <div id="footer" class="span12 center none">

        <div id="footer_widgets_wrap">

            <div class="row">

                <div id="footer_widget_left" class="span4">

                    <?php 

                    if (is_active_sidebar( 'Footer Left' )) { 

                        dynamic_sidebar( 'Footer Left' );

                    } else {   

                        if (nimbus_get_option('example_widgets') == "on") {

                        ?>

                            <div class="footer_widget sidebar sidebar_editable">

                                <?php

                                the_widget('WP_Widget_Recent_Posts');

                                ?>

                            </div>

                        <?php    

                        } 

                    } 

                    ?>

                </div>			

                <div id="footer_widget_center" class="span4">

                    <?php 

                    if (is_active_sidebar( 'Footer Center' )) { 

                        dynamic_sidebar( 'Footer Center' );

                    } else {   

                        if (nimbus_get_option('example_widgets') == "on") {

                        ?>

                            <div class="footer_widget sidebar sidebar_editable">

                                <?php

                                    $rss_options = array( 

                                        'title' => 'WordPress News Feed',  

                                        'url' => 'http://wordpress.org/news/feed/', 

                                        'items' => 7

                                    );

                                    the_widget('WP_Widget_RSS', $rss_options); 

                                ?>

                            </div>

                        <?php    

                        } 

                    } 

                    ?>

                </div>			

                <div id="footer_widget_right" class="span4">

                    <?php 

                    if (is_active_sidebar( 'Footer Right' )) { 

                        dynamic_sidebar( 'Footer Right' );

                    } else {    

                        if (nimbus_get_option('example_widgets') == "on") {

                        ?>

                            <div class="footer_widget sidebar sidebar_editable">

                                <?php

                                the_widget( 'WP_Widget_Tag_Cloud'); 

                                ?>

                            </div>

                        <?php    

                        } 

                    } 

                    ?>

                </div>

            </div>

            <div class="clear"></div>

        </div>

        <div id="footer_base">

            <div id="footer_meta">

                <ul id="contact">

                    <?php if (nimbus_get_option('image_logo') == "") { ?>

                        <li><p id="footer_text_logo"><?php echo nimbus_get_option('text_logo') ?></p></li> 

                    <?php } ?>

                    <?php if (nimbus_get_option('address') != "") { ?>

                        <li><?php echo wpautop(nimbus_get_option('address')) ?></li>

                    <?php } ?>

                    <?php if ((nimbus_get_option('public_phone') || nimbus_get_option('public_fax')) != "") { ?>

                        <li><p><?php if (nimbus_get_option('public_phone') != "") { ?>

                                    <span>t </span><?php echo nimbus_get_option('public_phone') ?><br />

                                <?php } ?><?php if (nimbus_get_option('public_fax') != "") { ?>

                                    <span>f </span><?php echo nimbus_get_option('public_fax') ?>

                                <?php } ?></p></li>

                    <?php } ?>

                </ul>

                <?php if (nimbus_get_option('display_social_buttons') == 1) { ?>

                    <ul id="social">

                        <?php if (nimbus_get_option('facebook_url') != "") { ?>

                            <li id="facebook_footer_button"><a target="_blank" href="<?php echo nimbus_get_option('facebook_url') ?>"></a></li>

                        <?php } ?>

                        <?php if (nimbus_get_option('linkedin_url') != "") { ?>				

                            <li id="linkedin_footer_button"><a target="_blank" href="<?php echo nimbus_get_option('linkedin_url') ?>"></a></li>

                        <?php } ?>

                        <?php if (nimbus_get_option('twitter_url') != "") { ?>						

                            <li id="twitter_footer_button"><a target="_blank" href="<?php echo nimbus_get_option('twitter_url') ?>"></a></li>

                        <?php } ?>

                        <?php if (nimbus_get_option('youtube_url') != "") { ?>						

                            <li id="youtube_footer_button"><a target="_blank" href="<?php echo nimbus_get_option('youtube_url') ?>"></a></li>

                        <?php } ?>	

                        <?php if (nimbus_get_option('google_plus_url') != "") { ?>						

                            <li id="google_plus_footer_button"><a target="_blank" href="<?php echo nimbus_get_option('google_plus_url') ?>"></a></li>

                        <?php } ?>	

                        <li id="rss_footer_button"><a target="_blank" href="<?php bloginfo('rss2_url'); ?>"></a></li>

                    </ul>

                <?php } ?>	

                <div class="clear"></div>
                

            </div>
            

            <p id="copyright"><?php echo nimbus_get_option('copyright') ?></p>
           
            

         <!-- <p id="credit">Designed By <a href="http://acutegroups.org/" target="_blank">Acutegroups</a></p> -->

        </div>	
        <div style=" width:900px; line-height:15px; padding-bottom:10px; margin:0 auto; text-align:center;" ><h1 style="margin:0; font-weight:normal; padding:0; font-size:10px; color: #FFFFFF; font-family:Verdana,Arial,Helvetica, sans-serif;"><a href="http://wheelrepairofnj.com/" style="font-size:10px; color:#FFFFFF"><u>Rim Repair NJ</u></a> | <a href="http://wheelrepairofnj.com/" style="font-size:10px; color:#FFFFFF"><u>Wheel Repair NJ</u></a> |  <a href="http://wheelrepairofnj.com/services/" style="font-size:10px; color:#FFFFFF"><u>BMW Repair NJ</u></a> | <a href="http://wheelrepairofnj.com/services/alloy-wheel-repair/" style="font-size:10px; color:#FFFFFF"><u>Alloy Rim Repair NJ</u></a> | <a href="http://wheelrepairofnj.com/auto-detailing/" style="font-size:10px; color:#FFFFFF"><u>Auto Detailing NJ</u></a> | <a href="http://wheelrepairofnj.com/auto-detailing/" style="font-size:10px; color:#FFFFFF"><u>Car Detailing NJ</u></a> | <a href="http://wheelrepairofnj.com/headlight-restoration/" style="font-size:10px; color:#FFFFFF"><u>Headlight Restoration Service</u></a> | <a href="http://wheelrepairofnj.com/interior-repair-2/" style="font-size:10px; color:#FFFFFF"><u>Auto Interior Repair</u></a> | <a href="http://wheelrepairofnj.com/services/lease-return-preparation/" style="font-size:10px; color:#FFFFFF"><u>Best Auto Lease Deals</u></a> | <a href="http://wheelrepairofnj.com/services/lease-return-preparation/" style="font-size:10px; color:#FFFFFF"><u>Auto Lease Deals</u></a> | <a href="http://wheelrepairofnj.com/services/powder-coating/" style="font-size:10px; color:#FFFFFF"><u>Powder Coating NJ</u></a> | <a href="http://wheelrepairofnj.com/paint-touch-up/" style="font-size:10px; color:#FFFFFF"><u>Auto Paint Touch Up</u></a> | <a href="http://wheelrepairofnj.com/window-tinting/" style="font-size:10px; color:#FFFFFF"><u>Car Window Tinting</u></a></h1></div>	

    </div>

</div>

<?php wp_footer(); ?>
		

</body>

</html>

