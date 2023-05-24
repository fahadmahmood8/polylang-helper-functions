<?php

	/*		
		SHORTCODE PURPOSE: YOU MAY GET POST/PAGE/PRODUCT CONTENT USING THIS SHORTCODE
		SHORTCODE USAGE EXAMPLE: [pll-content id="2023"]
		AUTHOR: FAHAD MAHMOOD
		PROFILE: https://profiles.wordpress.org/fahadmahmood/#content-plugins
	*/	
	
	if(!function_exists('polylang_translated_content')){
		function polylang_translated_content( $atts ) {
			
			$locale = get_locale();
			$locale = explode('_', $locale);
			$locale = current($locale);
			
	
			
			$a = shortcode_atts( array(
				'id' => '',
			), $atts );
			$post_content = '';
			$post_id = (is_numeric($a['id'])?$a['id']:0);
			
			if($post_id && function_exists('pll_get_post_translations')){
				$post_translations = pll_get_post_translations($post_id);
				
				$post_id = (array_key_exists($locale, $post_translations)?$post_translations[$locale]:$post_id);
			
				$post = get_post($post_id);
	
				if(is_object($post)){
				
					$post_content = $post->post_content;
					
				}
				
			}
	
		
			$meta = strip_tags(apply_filters('the_content', $post_content));
			
			$fnd = array("\n","\r");
			$rep = array('','');
			
			$meta = str_replace($fnd, $rep, $meta);
			return $meta;
		
		}
	}
	
	add_shortcode( 'pll-content', 'polylang_translated_content' );