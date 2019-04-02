<?php

//function wpmlsupp_1706_reset_wpml_capabilities() {
//	    if ( function_exists( 'icl_enable_capabilities' ) ) {
//		            icl_enable_capabilities();
//			        }
//}
//add_action( 'shutdown', 'wpmlsupp_1706_reset_wpml_capabilities' );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

//add_filter( 'edd_get_price_name', 'remove_strong_in_price_name');
function remove_strong_in_price_name( $name, $item_id = 0, $item = array() ){
    $name = str_replace('<strong>', '', $name);
    $name = str_replace('</strong>', '', $name);
    return $name;
}
add_filter( 'edd_get_cart_item_name', 'remove_strong_in_price_name');

// to set the campaign meta in the payment
function add_payment_campaign_meta( $payment_id ){//, $new_status, $old_status ) {
  $cart_items   = edd_get_payment_meta_cart_details( $payment_id );
  if( !isset($cart_items[0]['id']) ) {

  } else {
    $product = $cart_items[0]['id'];
    $product_meta = get_post_meta( $payment_id, '_edd_payment_campaign');
    if(!$product_meta || $product_meta != $product){
      update_post_meta( $payment_id, '_edd_payment_campaign', $product);
    }
  }
}
add_action( 'edd_update_payment_status', 'add_payment_campaign_meta');
//add_filter( 'edd_payment', 'add_payment_campaign_meta' );

function count_posts($language_code = '', $post_type = 'post', $post_status = 'publish'){

	global $sitepress, $wpdb;

	//get default language code
	$default_language_code = $sitepress->get_default_language();

	//adjust post type to format WPML uses 
	switch($post_type){
		case 'page':
			$post_type = 'post_page';
		break;		
		case 'post':
			$post_type = 'post_post';
		break;
		case 'download':
			$post_type = 'post_download';
		break;
	}
	
	//are we dealing with originals or translations?
	$slc_param = $sitepress->get_default_language() == $language_code ? "IS NULL" : "= '{$default_language_code}'";

	$query = "SELECT COUNT( {$wpdb->prefix}posts.ID )
				FROM {$wpdb->prefix}posts
				LEFT JOIN {$wpdb->prefix}icl_translations ON {$wpdb->prefix}posts.ID = {$wpdb->prefix}icl_translations.element_id
				WHERE {$wpdb->prefix}icl_translations.language_code = '{$language_code}'
				AND {$wpdb->prefix}icl_translations.source_language_code $slc_param
				AND {$wpdb->prefix}icl_translations.element_type = '{$post_type}'
				AND {$wpdb->prefix}posts.post_status = '$post_status'";

return $wpdb->get_var( $query );
}

/**
 *  Checks if a post is the original or not
 *  
 * @param int $post_id The post ID to check. Leave on 0 if using within a loop
 * @param string $type The element type to check: post_post|post_page|post_custom Defaults to post_post
 *  
 * @return array
 *  */
function wpml_is_original($post_id = 0, $type = 'post_post'){
    global $post, $sitepress;
     
    $output = array();
     
    // use current post if post_id is not provided
    $p_ID = $post_id == 0 ? $post->ID : $post_id;
 
    $el_trid = $sitepress->get_element_trid($p_ID, $type);
    $el_translations = $sitepress->get_element_translations($el_trid, $type);
 
    if(!empty($el_translations)){
        $is_original = FALSE;
        $original_ID = 0;
        foreach($el_translations as $lang => $details){
            if($details->original == 1 && $details->element_id == $p_ID){
                $is_original = TRUE;
            }
            if($details->original == 1){
                $original_ID = $details->element_id;
            }
        }
        $output['is_original'] = $is_original;
        $output['original_ID'] = $original_ID;
    }
return $output;
}

function rebuild_payment_campaign_meta(){
  $args = array('number'=>1000);
  $payments = new EDD_Payments_Query( $args );
  $payments = $payments->get_payments();
  $result = '';
  if( $payments ) {

    foreach( $payments as $payment ) {

      $cart_items   = edd_get_payment_meta_cart_details( $payment->ID );
      $product = $cart_items[0]['id'];
      $product_meta = get_post_meta( $payment->ID, '_edd_payment_campaign');
      if(!$product_meta || $product_meta != $product){
        update_post_meta( $payment->ID, '_edd_payment_campaign', $product);
        $result .= $payment->ID.'('.$product.'), ';
      }
    }
    wp_reset_postdata();

    return $result;
  }
  wp_reset_postdata();
  return 'Error! '.$payments;
}

?>
