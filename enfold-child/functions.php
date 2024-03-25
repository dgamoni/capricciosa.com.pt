<?php

/*
* Add your own functions here. You can also copy some of the theme functions into this file. 
* Wordpress will use those functions instead of the original functions then.
*/

add_action('wp_footer', 'add_custom_css');
function add_custom_css() { ?>
	<script>
		jQuery(document).ready(function($) {

			$('.wrap_h1 .avia_image').wrap('<h1></h1>');

			var logo = '<span class="logo logo-mobile"><a href="https://capricciosa.com.pt/"><img height="100" width="300" src="https://capricciosa.com.pt/wp-content/uploads/2018/06/capricciosa-pizzas-artesanais-logo-branco.svg" alt="Pizzaria Capricciosa"></a></span>';
			$('.av-burger-overlay').appendTo(logo);
			
		});

		$(document).on('click', '.av-burger-menu-main a', function(event) {
		 	var logo = '<span class="logo_ logo-mobile"><a href="https://capricciosa.com.pt/"><img height="100" width="300" src="https://capricciosa.com.pt/wp-content/uploads/2018/06/capricciosa-pizzas-artesanais-logo-branco.svg" alt="Pizzaria Capricciosa"></a></span>';
		 	jQuery('#av-burger-menu-ul').prepend(logo);
		});


	</script>
	<style>

.menu-item-language.menu-item-top-level > a > span.avia-menu-text {
    border: 1px solid;
    border-radius: 10px;
    padding: 3px 16px 3px 13px;
}
.wpml-ls-current-language.av-active-burger-items > a > span.avia-menu-text {
    border: 1px solid;
    border-radius: 10px;
    padding: 3px 16px 3px 13px;
}
.menu-item-language.menu-item-top-level  > a > span.avia-menu-text .wpml-ls-display:after {
	content: ">";
	    font-size: 16px;
    margin-left: 5px;
    font-family: monospace;
       transform: rotate(90);
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
    -webkit-transform: rotate(90deg);
    display: inline-block;
}
/*div.av-burger-overlay-bg {
    background-color: transparent;
}
#top #wrap_all .av-burger-overlay-scroll {
    background-color: transparent;
}
.html_av-overlay-full #top #wrap_all #av-burger-menu-ul li {
    background-color: #a6483e;
}*/
.responsive #top .logo.logo-mobile {

}


	</style>
	<?php
}


function avia_remove_main_menu_flags(){
	remove_filter( 'wp_nav_menu_items', 'avia_append_lang_flags', 9998, 2 );
	remove_filter( 'avf_fallback_menu_items', 'avia_append_lang_flags', 9998, 2 );
	remove_action( 'avia_meta_header', 'avia_wpml_language_switch', 10);
		//add_filter( 'wp_nav_menu_items', 'avia_append_lang_flags_child', 9998, 2 );
		//add_filter( 'avf_fallback_menu_items', 'avia_append_lang_flags_child', 9998, 2 );

	//remove_filter( 'wp_nav_menu_items', 'avia_append_burger_menu', 9998, 2 );
	//remove_filter( 'avf_fallback_menu_items', 'avia_append_burger_menu', 9998, 2 );
}
add_action('after_setup_theme','avia_remove_main_menu_flags');
	
function avia_append_lang_flags_child( $items, $args )
{
    if ((is_object($args) && $args->theme_location == 'avia'))
    {
        global $avia_config, $sitepress;

        if(empty($avia_config['wpml_language_menu_position'])) $avia_config['wpml_language_menu_position'] = apply_filters('avf_wpml_language_switcher_position', 'main_menu');
        if($avia_config['wpml_language_menu_position'] != 'main_menu') return $items;

        $languages = icl_get_languages('skip_missing=0&orderby=custom');

        if(is_array($languages))
        {
        	$items .="<div class='lang_menu'>";
            foreach($languages as $lang)
            {
                $currentlang = (ICL_LANGUAGE_CODE == $lang['language_code']) ? 'avia_current_lang' : '';

                if(is_front_page()) $lang['url'] = $sitepress->language_url($lang['language_code']);
                //var_dump($lang);
                $items .= "<li class='av-language-switch-item language_".$lang['language_code']." $currentlang'><a href='".$lang['url']."'>";
                //$items .= "	<span class='language_flag'><img title='".$lang['native_name']."' src='".$lang['country_flag_url']."' /></span>";
                $items .= $lang['tag'];
                $items .= "</a></li>";
            }
            $items .= "</div>";
        }
    }
    return $items;
}


