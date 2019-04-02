<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Fundify
 * @since Fundify 1.0
 */
?>

	<footer id="footer">
	<div class="legal-terms stats">
		<h3><?php _e( 'Get the Stats', 'fundify-child' );//_e('Legal Terms', 'fundify-child'); ?></h3>

                <?php // bumbum
                                        $args = array('fields' => 'ids', 'post_type' => 'download', 'numberposts' => -1, 'status' => 'publish');
                                        $the_query = get_posts( $args );
                                        $originals = array();
                                        foreach($the_query as $id){
                                          $obj = wpml_is_original($id, 'post_download');
                                          if($obj['is_original']) 
                                            $originals[] = $id;
                                        }
                                        $campaigns_total = count($originals); //count_posts(ICL_LANGUAGE_CODE, 'download', 'publish');
                                        //$campaigns_cat = count_posts('ca', 'download', 'publish');
                                        //$campaigns_esp = count_posts('es', 'download', 'publish');
                                        //if( $campaigns_total < $campaigns_cat ) $campaigns_total = $campaigns_cat;
                                        //if( $campaigns_total < $campaigns_esp ) $campaigns_total = $campaigns_esp; ?>


		<ul>
			<?php //wp_list_pages('meta_key=legal_page&sort_column=menu_order&title_li=<h2>' . __('Poetry') . '</h2>' ); //include=1149,1146& //bumbum: eren les id's de les condicions d'us, ara usen el meta_key=legal_page ?>

                      <li><?php printf( '<strong>%s</strong> %s', $campaigns_total, _n( edd_get_label_singular(), edd_get_label_plural(), $campaigns_total ) ); // bumbum  wp_count_posts( 'download' )->publish, _n( edd_get_label_singular(), edd_get_label_plural(), wp_count_posts( 'download' )->publish ) ); ?></li>
                      <li><?php printf( __( '<strong>%s</strong> Funded', 'fundify-child' ), edd_currency_filter( edd_format_amount( edd_get_total_earnings() ) ) ); ?></li>

		</ul>
	</div>
		
			<div class="last-widget">
				<?php //if ( fundify_is_crowdfunding() ) : ?>
				<?php  //<h3> <php _e( 'Get the Stats', 'fundify-child' ); > </h3> ?>

				<?php // bumbum
					/*$campaigns_total = count_posts(ICL_LANGUAGE_CODE, 'download', 'publish');
					$campaigns_cat = count_posts('ca', 'download', 'publish');
					$campaigns_esp = count_posts('es', 'download', 'publish');
					if( $campaigns_total < $campaigns_cat ) $campaigns_total = $campaigns_cat;
					if( $campaigns_total < $campaigns_esp ) $campaigns_total = $campaigns_esp;*/ ?>
				<!-- <ul>
					<li><?php //printf( '<strong>%s</strong> %s', $campaigns_total, _n( edd_get_label_singular(), edd_get_label_plural(), $campaigns_total ) ); // bumbum  wp_count_posts( 'download' )->publish, _n( edd_get_label_singular(), edd_get_label_plural(), wp_count_posts( 'download' )->publish ) ); ?></li>
					<li><?php //printf( __( '<strong>%s</strong> Funded', 'fundify-child' ), edd_currency_filter( edd_format_amount( edd_get_total_earnings() ) ) ); ?></li>
				</ul> -->
				<?php //endif; ?>

				<div class="copy">
					<a href="<?php echo home_url(); ?>">
						<img src="<?php echo esc_url( fundify_theme_mod( 'footer_logo_image' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="footer-logo">
					</a>
					<p><?php printf( __( 'Copyleft:  %s, %s', 'fundify-child' ), get_bloginfo( 'name' ), date( 'Y' ) ); //bumbum: tocat l'string original 'copyright' ?></p>
				</div>
			</div>
		</div>
		<!-- / container -->
	</footer>
	<!-- / footer -->

	<?php wp_footer(); ?>
</body>
</html>
