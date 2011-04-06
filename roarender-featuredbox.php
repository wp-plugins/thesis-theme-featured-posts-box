<?php

/*
Plugin Name: Roarender Featured Posts Box
Plugin URI: http://roarender.com/
Description: An animated featured posts box plugin
Version: 1.0.0
Author: Roarender
Author URI: http://roarender.com
License: GPL
rainsarabia 2011
rainier@roarender.com
*/


// Plugin Init
add_action('init', 'rr_fb_init');
function rr_fb_init()
{
 
    create_featured_post_category();
    
    if(is_admin())
    {
        global $plugin_url; $plugin_url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
        add_action('admin_menu', 'rr_fb_admin_menu');
        wp_enqueue_script('jscolor', $plugin_url . 'js/jscolor/jscolor.js');                                                        
        add_action('admin_head', add_admin_scripts);
    }
    
}

function add_admin_scripts()
{ 
    global $plugin_url; $plugin_url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));  
    ?>        



<script type='text/javascript'>

    /*jQuery(function($){
        $('#frm-img-btn').click(function(){
            $.post("<?php //echo $plugin_url; ?>ajax.php", $('#frm-img').serialize() ,   
            function(data)  
            {
                alert(data); 
            }); 
        });                     
    }); */

</script> <!--ajax-->

    <style type='text/css'>
    #rrfb-left {float:left; width:770px; height:auto; }
    #rrfb-right {float:left; width:auto; height:auto; margin:0 0 0 12px; }
    </style>
    
<?php }

// Install / Uninstall
register_activation_hook(__FILE__,'rr_fb_install'); 
register_deactivation_hook( __FILE__, 'rr_fb_uninstall' );

function rr_fb_install()
{
    add_option("rr_fb_size", 'normal', '', 'yes');
    add_option("rr_fb_items", '3', '', 'yes');   
    add_option("rr_fb_secondary_img", '1', '', 'yes');    
    
    // Colors    
    add_option("rr_fb_border_color", 'DCDCDC', '', 'yes');      
    add_option("rr_fb_primary_bg", 'FFF', '', 'yes');    
    add_option("rr_fb_primary_font_color", '070707', '', 'yes');        
    add_option("rr_fb_sidebar_bg", 'E0E0E0', '', 'yes');    
    add_option("rr_fb_sidebar_font_color", '070707', '', 'yes'); 
    add_option("rr_fb_sidebar_highlight_bg", 'E9E9E9', '', 'yes');            
    add_option("rr_fb_footer_bg", 'E0E0E0', '', 'yes');    
    
    // Animation  
    add_option("rr_fb_animation_speed", '3000', '', 'yes');   
    add_option("rr_fb_animation_slide_speed", '500', '', 'yes');    
    add_option("rr_fb_animation_restart", '10000', '', 'yes');    
    
    // ads
    add_option("rr_fb_ad", '1', '', 'yes');            
    
    
}

function rr_fb_uninstall()
{
    delete_option('rr_fb_border_color');
    delete_option('rr_fb_primary_bg');
    delete_option('rr_fb_primary_font_color');
    delete_option('rr_fb_sidebar_bg');
    delete_option('rr_fb_sidebar_font_color');
    delete_option('rr_fb_sidebar_highlight_bg');
    delete_option('rr_fb_footer_bg');  
    delete_option('rr_fb_animation_speed');    
    delete_option('rr_fb_animation_slide_speed'); 
    delete_option('rr_fb_animation_restart');    
   
}

function create_featured_post_category()
{
    global $wpdb;
    $query = "INSERT `" . $wpdb->prefix. "terms` SET `name` = 'Featured', `slug` = 'featured';";
    $query2 = "INSERT `" . $wpdb->prefix. "term_taxonomy` SET `term_id` = (SELECT `term_id` FROM " . $wpdb->prefix. "terms WHERE `slug` = 'featured'), `taxonomy` = 'category';";
    
    $wpdb->query($query); 
    $wpdb->query($query2);     
}

function rr_fb_admin_menu()
{
    add_options_page('RR Featured Box', 'RR Featured Box', 'administrator', 'rr-featured-box', 'rr_fb_html_page');

}

function rr_fb_html_page()
{ ?>
    
    <div class='wrap'>
        <div id="icon-options-general" class="icon32"><br></div>
        <h2>Roarender Featured Posts Box Plugin</h2>
    
        
        <div id='rrfb-left'>
        
        <form method='post' action='options.php'>
        
        <?php wp_nonce_field('update-options'); ?>

        
        <table>
                <tr>
                    <td>
                        <h4>To use the plugin, please choose an option:</h4>
                    </td>    
                    
                </tr>
                <tr>
                    <td>            
                        <input type='radio' name='rr_fb_ad' value='1' <?php if(get_option('rr_fb_ad') == '1') echo "checked='checked'" ?> /> Have a "Web Application Development Powered By Roarender" line of text added below the plugin in small text.
                        
                        <br /><br />
                        <input type='radio' name='rr_fb_ad' value='2' <?php if(get_option('rr_fb_ad') == '2') echo "checked='checked'" ?> /> Have our graphic displayed in the corner of the plugin.
                    </td>
                </tr>
        </table>
        
        <br />
        
        
            <table>
                
            
                <tr>
                
                    <td><h4>Featured Posts Box Size:</h4></td>         
                    <td>
                        &nbsp;&nbsp;
                        <input type='radio' name='rr_fb_size' value='normal' <?php if(get_option('rr_fb_size') == 'normal') echo "checked='checked'" ?> /> Normal
                        &nbsp;&nbsp;
                        <input type='radio' name='rr_fb_size' value='small' <?php if(get_option('rr_fb_size') == 'small') echo "checked='checked'" ?> /> Small
                    </td>  
                    
                <tr>
                    <td><h4>Featured Items:</h4></td>         
                    <td>
                        &nbsp;&nbsp;
                        <input type='radio' name='rr_fb_items' value='3' <?php if(get_option('rr_fb_items') == '3') echo "checked='checked'" ?> /> 3
                        &nbsp;&nbsp;
                        <input type='radio' name='rr_fb_items' value='4' <?php if(get_option('rr_fb_items') == '4') echo "checked='checked'" ?> /> 4
                        &nbsp;&nbsp;
                        <input type='radio' name='rr_fb_items' value='5' <?php if(get_option('rr_fb_items') == '5') echo "checked='checked'" ?> /> 5
                    </td>
                </tr>
                
                <tr>
                    <td><h4>Sidebar Thumbs:</h4></td>         
                    <td>
                        &nbsp;&nbsp;
                        <input type='radio' name='rr_fb_secondary_img' value='1' <?php if(get_option('rr_fb_secondary_img') == '1') echo "checked='checked'" ?> /> Enable
                        &nbsp;&nbsp;
                        <input type='radio' name='rr_fb_secondary_img' value='0' <?php if(get_option('rr_fb_secondary_img') == '0') echo "checked='checked'" ?> /> Disable
                    </td>
                </tr>    
                      
                </tr>
                
                 
                <tr>
                    <td>
                        <h4>Featured Posts Box Border Color:</h4>
                    </td>    
                    <td>
                        <input type='text' name='rr_fb_border_color' class='color' value='<?php echo get_option('rr_fb_border_color'); ?>' /> 
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <h4>Featured Posts Box Background Color:</h4>
                    </td>    
                    <td>
                        <input type='text' name='rr_fb_primary_bg' class='color' value='<?php echo get_option('rr_fb_primary_bg'); ?>' /> 
                    </td>
                </tr>    
                
                <tr>
                    <td>
                        <h4>Featured Posts Box Font Color:</h4>
                    </td>    
                    <td>
                        <input type='text' name='rr_fb_primary_font_color' class='color' value='<?php echo get_option('rr_fb_primary_font_color'); ?>' /> 
                    </td>
                    
                </tr> 
                
                
                <tr>
                    <td>
                        <h4>Sidebar Background Color:</h4>
                    </td>    
                    <td>
                        <input type='text' name='rr_fb_sidebar_bg' class='color' value='<?php echo get_option('rr_fb_sidebar_bg'); ?>' /> 
                    </td>                    
                </tr>
                
                <tr>
                    <td>
                        <h4>Sidebar Font Color:</h4>
                    </td>    
                    <td>
                        <input type='text' name='rr_fb_sidebar_font_color' class='color' value='<?php echo get_option('rr_fb_sidebar_font_color'); ?>' /> 
                    </td>                    
                </tr>
                
                <tr>
                    <td>
                        <h4>Sidebar Highlight Background:</h4>
                    </td>    
                    <td>
                        <input type='text' name='rr_fb_sidebar_highlight_bg' class='color' value='<?php echo get_option('rr_fb_sidebar_highlight_bg'); ?>' /> 
                    </td>                    
                </tr>
                
                <tr>
                    <td>
                        <h4>Footer Background:</h4>
                    </td>    
                    <td>
                        <input type='text' name='rr_fb_footer_bg' class='color' value='<?php echo get_option('rr_fb_footer_bg'); ?>' /> 
                    </td>                    
                </tr>
                
                <tr>
                    <td>
                        <h4>Animation Slide Transition Speed:</h4>
                    </td>    
                    <td>
                        <select name='rr_fb_animation_speed'>
                            <option value='500' <?php if(get_option('rr_fb_animation_speed') == 500) echo "selected='selected'";  ?> >.5</option>
                            <option value='1000' <?php if(get_option('rr_fb_animation_speed') == 1000) echo "selected='selected'";  ?> >1</option>
                            <option value='1500' <?php if(get_option('rr_fb_animation_speed') == 1500) echo "selected='selected'";  ?> >1.5</option>
                            <option value='2000' <?php if(get_option('rr_fb_animation_speed') == 2000) echo "selected='selected'";  ?> >2</option>
                            <option value='2500' <?php if(get_option('rr_fb_animation_speed') == 2500) echo "selected='selected'";  ?> >2.5</option>
                            <option value='3000' <?php if(get_option('rr_fb_animation_speed') == 3000) echo "selected='selected'";  ?> >3</option>
                            <option value='3500' <?php if(get_option('rr_fb_animation_speed') == 3500) echo "selected='selected'";  ?> >3.5</option>
                            <option value='4000' <?php if(get_option('rr_fb_animation_speed') == 4000) echo "selected='selected'";  ?> >4</option>
                            <option value='4500' <?php if(get_option('rr_fb_animation_speed') == 4500) echo "selected='selected'";  ?> >4.5</option>
                            <option value='5000' <?php if(get_option('rr_fb_animation_speed') == 5000) echo "selected='selected'";  ?> >5</option>
                            
                            <option value='5500' <?php if(get_option('rr_fb_animation_speed') == 5500) echo "selected='selected'";  ?> >5.5</option>
                            <option value='6000' <?php if(get_option('rr_fb_animation_speed') == 6000) echo "selected='selected'";  ?> >6</option>
                            <option value='6500' <?php if(get_option('rr_fb_animation_speed') == 6500) echo "selected='selected'";  ?> >6.5</option>
                            <option value='7000' <?php if(get_option('rr_fb_animation_speed') == 7000) echo "selected='selected'";  ?> >7</option>
                            <option value='7500' <?php if(get_option('rr_fb_animation_speed') == 7500) echo "selected='selected'";  ?> >7.5</option>
                            <option value='8000' <?php if(get_option('rr_fb_animation_speed') == 8000) echo "selected='selected'";  ?> >8</option>
                            <option value='8500' <?php if(get_option('rr_fb_animation_speed') == 8500) echo "selected='selected'";  ?> >8.5</option>
                            <option value='9000' <?php if(get_option('rr_fb_animation_speed') == 9000) echo "selected='selected'";  ?> >9</option>
                            <option value='9500' <?php if(get_option('rr_fb_animation_speed') == 9500) echo "selected='selected'";  ?> >9.5</option>
                            <option value='10000' <?php if(get_option('rr_fb_animation_speed') == 10000) echo "selected='selected'";  ?> >10</option>
                        </select>  Seconds
                    </td>                    
                </tr>
                
                <tr>
                    <td>
                        <h4>Animation Slide Speed:</h4>
                    </td>    
                    <td>
                        <select name='rr_fb_animation_slide_speed'>
                            <option value='500' <?php if(get_option('rr_fb_animation_slide_speed') == 500) echo "selected='selected'";  ?> >.5</option>
                            <option value='1000' <?php if(get_option('rr_fb_animation_slide_speed') == 1000) echo "selected='selected'";  ?> >1</option>
                            <option value='1500' <?php if(get_option('rr_fb_animation_slide_speed') == 1500) echo "selected='selected'";  ?> >1.5</option>
                            <option value='2000' <?php if(get_option('rr_fb_animation_slide_speed') == 2000) echo "selected='selected'";  ?> >2</option>
                            <option value='2500' <?php if(get_option('rr_fb_animation_slide_speed') == 2500) echo "selected='selected'";  ?> >2.5</option>
                            <option value='3000' <?php if(get_option('rr_fb_animation_slide_speed') == 3000) echo "selected='selected'";  ?> >3</option>
                            <option value='3500' <?php if(get_option('rr_fb_animation_slide_speed') == 3500) echo "selected='selected'";  ?> >3.5</option>
                            <option value='4000' <?php if(get_option('rr_fb_animation_slide_speed') == 4000) echo "selected='selected'";  ?> >4</option>
                            <option value='4500' <?php if(get_option('rr_fb_animation_slide_speed') == 4500) echo "selected='selected'";  ?> >4.5</option>
                            <option value='5000' <?php if(get_option('rr_fb_animation_slide_speed') == 5000) echo "selected='selected'";  ?> >5</option>
                            
                            <option value='5500' <?php if(get_option('rr_fb_animation_slide_speed') == 5500) echo "selected='selected'";  ?> >5.5</option>
                            <option value='6000' <?php if(get_option('rr_fb_animation_slide_speed') == 6000) echo "selected='selected'";  ?> >6</option>
                            <option value='6500' <?php if(get_option('rr_fb_animation_slide_speed') == 6500) echo "selected='selected'";  ?> >6.5</option>
                            <option value='7000' <?php if(get_option('rr_fb_animation_slide_speed') == 7000) echo "selected='selected'";  ?> >7</option>
                            <option value='7500' <?php if(get_option('rr_fb_animation_slide_speed') == 7500) echo "selected='selected'";  ?> >7.5</option>
                            <option value='8000' <?php if(get_option('rr_fb_animation_slide_speed') == 8000) echo "selected='selected'";  ?> >8</option>
                            <option value='8500' <?php if(get_option('rr_fb_animation_slide_speed') == 8500) echo "selected='selected'";  ?> >8.5</option>
                            <option value='9000' <?php if(get_option('rr_fb_animation_slide_speed') == 9000) echo "selected='selected'";  ?> >9</option>
                            <option value='9500' <?php if(get_option('rr_fb_animation_slide_speed') == 9500) echo "selected='selected'";  ?> >9.5</option>
                            <option value='10000' <?php if(get_option('rr_fb_animation_slide_speed') == 10000) echo "selected='selected'";  ?> >10</option>
                        </select>  Seconds
                    </td>                    
                </tr>
                
                <tr>
                    <td>
                        <h4>Animation Restart After Click:</h4>
                    </td>    
                    <td>
                        <select name='rr_fb_animation_restart'>
                            <option value='500' <?php if(get_option('rr_fb_animation_restart') == 500) echo "selected='selected'";  ?> >.5</option>
                            <option value='1000' <?php if(get_option('rr_fb_animation_restart') == 1000) echo "selected='selected'";  ?> >1</option>
                            <option value='1500' <?php if(get_option('rr_fb_animation_restart') == 1500) echo "selected='selected'";  ?> >1.5</option>
                            <option value='2000' <?php if(get_option('rr_fb_animation_restart') == 2000) echo "selected='selected'";  ?> >2</option>
                            <option value='2500' <?php if(get_option('rr_fb_animation_restart') == 2500) echo "selected='selected'";  ?> >2.5</option>
                            <option value='3000' <?php if(get_option('rr_fb_animation_restart') == 3000) echo "selected='selected'";  ?> >3</option>
                            <option value='3500' <?php if(get_option('rr_fb_animation_restart') == 3500) echo "selected='selected'";  ?> >3.5</option>
                            <option value='4000' <?php if(get_option('rr_fb_animation_restart') == 4000) echo "selected='selected'";  ?> >4</option>
                            <option value='4500' <?php if(get_option('rr_fb_animation_restart') == 4500) echo "selected='selected'";  ?> >4.5</option>
                            <option value='5000' <?php if(get_option('rr_fb_animation_restart') == 5000) echo "selected='selected'";  ?> >5</option>
                            
                            <option value='5500' <?php if(get_option('rr_fb_animation_restart') == 5500) echo "selected='selected'";  ?> >5.5</option>
                            <option value='6000' <?php if(get_option('rr_fb_animation_restart') == 6000) echo "selected='selected'";  ?> >6</option>
                            <option value='6500' <?php if(get_option('rr_fb_animation_restart') == 6500) echo "selected='selected'";  ?> >6.5</option>
                            <option value='7000' <?php if(get_option('rr_fb_animation_restart') == 7000) echo "selected='selected'";  ?> >7</option>
                            <option value='7500' <?php if(get_option('rr_fb_animation_restart') == 7500) echo "selected='selected'";  ?> >7.5</option>
                            <option value='8000' <?php if(get_option('rr_fb_animation_restart') == 8000) echo "selected='selected'";  ?> >8</option>
                            <option value='8500' <?php if(get_option('rr_fb_animation_restart') == 8500) echo "selected='selected'";  ?> >8.5</option>
                            <option value='9000' <?php if(get_option('rr_fb_animation_restart') == 9000) echo "selected='selected'";  ?> >9</option>
                            <option value='9500' <?php if(get_option('rr_fb_animation_restart') == 9500) echo "selected='selected'";  ?> >9.5</option>
                            <option value='10000' <?php if(get_option('rr_fb_animation_restart') == 10000) echo "selected='selected'";  ?> >10</option>
                        </select>  Seconds
                    </td>                    
                </tr>
                
            </table>
            
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="rr_fb_ad,rr_fb_size,rr_fb_items,rr_fb_secondary_img,rr_fb_border_color,rr_fb_primary_bg,rr_fb_primary_font_color,rr_fb_sidebar_bg,rr_fb_sidebar_font_color,rr_fb_sidebar_highlight_bg,rr_fb_footer_bg,rr_fb_animation_speed,rr_fb_animation_slide_speed,rr_fb_animation_restart" />

            
            <br />
            <input type="submit" value="<?php _e('Save Changes') ?>" />

            
        </form> <!--form 1-->
        
        </div>
        
        <div id='rrfb-right'>

            <?php 
            global $plugin_url; $plugin_url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
            ?>
            
            <h4>Default Blank thumbnail</h4>
            <form method="post" id='frm-img' enctype="multipart/form-data" action="<?php echo $plugin_url; ?>ajax.php">
            <input type="file" name="image" >
            <input type="submit" name="Submit" value="Upload" id='frm-img-btn'>
            <br />
            (max size of 250kb / jpg only)
            </form>  <!--form 2-->  
            
            <br />
            <img src='<?php echo $plugin_url; ?>img/blank.jpg' width=200 height=200 style='border:solid 2px #333; padding:2px;'/>

        </div>

    
    </div> 
    
<?php }


// Safely include CSS and JS files
add_action('wp_head', 'include_files',0);
function include_files() {
    
    if (!is_admin()) 
    {                
        global $plugin_url; $plugin_url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
        wp_enqueue_script('jquery');        
        wp_enqueue_script('loopedslider', $plugin_url . 'js/loopedslider.js');
        
        
        if(get_option('rr_fb_size') == 'normal')
        {
            wp_enqueue_style('roarender-featuredbox-css', $plugin_url . 'style.css');    
        }
        else
        {
            wp_enqueue_style('roarender-featuredbox-css', $plugin_url . 'style-small.css');
        }
        
    }

}

add_action('wp_head', 'add_rain_jscripts');
function add_rain_jscripts()
{ ?>

<script type="text/javascript">
    /*jQuery(window).load(function(){*/
    jQuery(function($){
        jQuery("#loopedslider").loopedSlider({
                autoStart: <?php echo get_option('rr_fb_animation_speed'); ?>, 
                slidespeed: <?php echo get_option('rr_fb_animation_slide_speed'); ?>, 
                containerClick: false,
                restart: <?php echo get_option('rr_fb_animation_restart'); ?>,
                autoHeight: true
        });
    });
    
</script> <!--looped slider-->

<style type='text/css'>

<?php if(get_option('rr_fb_items') == 3) : ?>
    #featured-box .container {height:300px !important; }
    .fea-top {height:280px !important; }

<?php elseif(get_option('rr_fb_items') == 4) : ?>
    #featured-box .container {height:390px !important; }
    
<?php elseif(get_option('rr_fb_items') == 5) : ?>
    #featured-box .container {height:495px !important; } 
    .fea-top {height:480px !important; }
    
    
<?php endif; ?>

<?php if(get_option('rr_fb_secondary_img') == '0') : ?>
    .fbrm-text {margin-left:20px; }
<?php endif; ?>

#fb-wrapper {border:solid 1px #<?php echo get_option('rr_fb_border_color'); ?>; background:#<?php echo get_option('rr_fb_primary_bg'); ?>;  }
#fb-wrapper .feature .post-content, #fb-wrapper .post-title a {color:#<?php echo get_option('rr_fb_primary_font_color'); ?>; }

#fb-wrapper .pagination li {background:#<?php echo get_option('rr_fb_sidebar_bg'); ?>;}
#fb-wrapper .pagination li a:hover, #fb-wrapper .pagination li.active a {background:#<?php echo get_option('rr_fb_sidebar_highlight_bg'); ?>;}
.fbrm-text {color:#<?php echo get_option('rr_fb_sidebar_font_color'); ?>;}

#fb-bot {background:#<?php echo get_option('rr_fb_footer_bg'); ?>;}

</style>




    
<?php }

    
add_action('thesis_hook_before_content_box', 'add_featured_box_etc');
function add_featured_box_etc()
{   ?>
    
    <div id='content-padding'>
    
    <?php if(is_front_page()) : ?>
    
    <!--@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@-->
    
    <div id='featured-box'>
    
    <div id='fb-wrapper'>
    
    <div id='fbt-img'> </div>
    
    <div id='fb-inner'> 
        <div id="loopedslider">
            <div class="container">
                <div class="slides">
                       <?php $my_query = new WP_Query('category_name=featured&showposts=' . get_option('rr_fb_items'));                    
                                while ($my_query->have_posts()) : $my_query->the_post();           
                                $do_not_duplicate = $post->ID; 
                                
                                global $plugin_url;
                                $plugin_url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
                                
                                ?> 
                                                         
                                <div class="feature"> 
                                    <div class='fea-top'>              
                                        <?php 
                                            $post_image = thesis_post_image_info('thumb');   //echo $post_image['output'];                          
                                        ?>
                                        
                                        <?php if($post_image['show'] == false) : ?>
                                            <div class='post-thumb'> 
                                                <a href='<?php the_permalink(); ?>'><img src='<?php echo $plugin_url;?>img/blank.jpg' /></a>
                                            </div>
                                        
                                        <?php else : ?>
                                        <div class='post-thumb'> 
                                                <?php echo $post_image['output'];?>
                                        </div>    
                                            
                                        <?php endif; ?>
                                        
                                        <div class='post-content'>
                                            <h1 class="post-title">      
                                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> 
                                            </h1>
                                            <?php the_date(); ?> | 
                                            <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?>  <br /><br />

                                            <?php the_excerpt(); ?>  
                                            <?php //edit_post_link(__('Edit'), ", ' | '); ?> 
                                            <br />
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <img src='<?php echo $plugin_url;?>img/readmore.png' />
                                            </a>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class='fea-bot'>
                                         <div class='fea-bot-left'>
                                            
                                            <?php 
                                                //$category = get_the_category($post->ID); 
                                                //echo $category[0]->cat_name;
                                                //the_category($post->ID);
                                                the_category($post->ID);
                                            ?>                                            
                                         </div>
                                         
                                         <div class='fea-bot-right'>
                                            <?php
                                                $posttags = get_the_tags();
                                                    if ($posttags) 
                                                    {
                                                        $x = 0;
                                                        foreach($posttags as $tag) 
                                                        {
                                                            if($x<2)
                                                            {
                                                                echo "<a href='?tag=". $tag->slug . "'>" . $tag->name . "</a> ";
                                                                $x++;
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo "No Tags";
                                                    }
                                            ?>
                                         </div>
                                    </div>
                                    
                                </div> <!--feature--> 
                                
                       <?php endwhile; ?>
                       
                  </div> <!--slides-->
            </div> <!--container-->
            
            <div id='fb-nav'>
                <ul class="pagination">
                        <?php $my_query = new WP_Query('category_name=featured&showposts=' . get_option('rr_fb_items'));                    
                        while ($my_query->have_posts()) : $my_query->the_post();           
                        $do_not_duplicate = $post->ID; ?> 
                                                       
                        <li class=''> 
                            <a class='fbrm-entry' href='#'>
                        
              
                                        <?php 
                                            $post_image = thesis_post_image_info('thumb');   //echo $post_image['output'];                          
                                        ?>
                                        
                                        <?php if(get_option('rr_fb_secondary_img') == '1') : ?>
                                        
                                            <?php if($post_image['show'] == false) : ?>
                                                    <img class='thumb alignleft' src='<?php echo $plugin_url;?>img/blank.jpg' />                                        
                                            <?php else : ?>                   
                                                    <?php echo $post_image['output'];?>
                                                
                                            <?php endif; ?>
                                        
                                            
                                        <?php endif; ?>
                  
                                        <span class='fbrm-text'>
                                            <h3 class="fbrm-title">      
                                                <?php //the_title(); 
                                                $title = get_the_title();
                                                $title = rr_fb_string_limit_words($title, 5);
                                                echo $title . "..";
                                                ?> 
                                            </h3>
                                            <?php //the_date(); ?>
                                            <?php //comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?> 

                                            <?php $excerpt = get_the_excerpt();
                                                $excerpt = str_replace('[display_podcast]', '', $excerpt);
                                              echo rr_fb_string_limit_words($excerpt,15);
                                            ?>  
                                            <?php //edit_post_link(__('Edit'), ", ' | '); ?> 
                                             
                                        </span>
                                        


                            </a>
                        </li>

                    <?php endwhile; ?>
                </ul> <!--pagination-->
            </div> <!--fb-nav-->
            
        </div>  <!--loopedslider-->
    </div>
    
    
    <div id='fb-bot'> 
    
        <div id='fbb-content'>
        
            <?php
            $ad_option = get_option('rr_fb_ad');
            ?>

            <?php if($ad_option == 2 ): ?>
                <script type="text/javascript">
                    jQuery(function($){
                        $('#fbb-content').html('<a href="http://www.roarender.com"><img src="<?php echo $plugin_url; ?>img/rr.jpg" /></a>'); 
                        $('#fbb-content img').css('margin-top', '-10px');
                    });
                </script>
                <noscript><a href="http://www.roarender.com">Web Application Development</a> - <a href="http://www.roarender.com/web-design">Web Design</a></noscript>
        
            
            <?php endif; ?>
        
        </div>
    
    </div>
                             
    </div>    
          
    <?php
    $ad_option = get_option('rr_fb_ad');
    ?>
            
    <?php if($ad_option == 1): ?>
        <div id='rr-fb-footer-link'><a href='http://www.roarender.com'><img src='<?php echo $plugin_url; ?>img/webdev.png'/></a> Powered By Roarender</div>
    <?php endif; ?>    
    
    
    
    </div> <!--featured-box-->
    
    
    
    <!--@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@-->
    

    <?php endif; ?> <!--is_front_page()-->
    
<?php }

function rr_fb_string_limit_words($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}
    
?>