<?php
/**
 * Campaign details.
 *
 * @package Fundify
 * @since Fundify 1.5
 */

global $campaign, $wp_embed;

// bumbum
function get_all_campaign_ids( $campaign_id ) {
          global $sitepress;

          $trid = $sitepress->get_element_trid($campaign_id, 'post_download');

          return wp_list_pluck( $sitepress->get_element_translations($trid, 'post_download'), 'element_id' );
}
/*function backers_of_any_lang( $args ){
          $ids = $this->get_all_campaign_ids( $args['post_parent'] );
          //$args['post_parent'] = '['.implode(',',$ids).']';
          //echo '<br> args:id = '.$args['post_parent'];
          return $args;
}*/
function bum_backers_count( $campaign_id ) {
    $ides = get_all_campaign_ids( $campaign_id );
    $allcount = 0;
    foreach( $ides as $id ){
         // bumbum copied from atcf_1.9.3
         $prices = edd_get_variable_prices( $id );
         $count  = 0;

         if ( empty( $prices ) ) {
                return $count;
         }

         foreach ( $prices as $price ) {
               $count += isset( $price[ 'bought' ] ) ? $price[ 'bought' ] : 0;
         }
         $allcount += $count;
    }
    return $allcount;
    //return absint( count( $this->unique_backers() ) );
}




?>

<article class="project-details">
	<!-- bumbum (amago div image-video del 'project-details', ara al sidebar): <div class="image">
		<?php if ( $campaign->video() ) : ?>
			<div class="video-container">
				<?php //echo $wp_embed->run_shortcode( '[embed]' . $campaign->video() . '[/embed]' ); ?>
			</div>
		<?php else : ?>
			<?php //the_post_thumbnail( 'blog' ); ?>
		<?php endif; ?>
	</div> -->
	<div class="right-side">
		<ul class="campaign-stats">
			<li class="progress">
				<h3><?php echo $campaign->current_amount(); ?></h3>
				<p><?php printf( __( 'Donated of %s Goal', 'fundify-child' ), $campaign->goal() ); ?></p>

				<div class="bar"><span style="width: <?php echo $campaign->percent_completed(); ?>"></span></div>
			</li>

			<li class="backer-count">
				<h3><?php echo bum_backers_count($campaign->ID); //$campaign->backers_count(); ?></h3>
				<p><?php echo _n( 'Backer', 'Backers', $campaign->backers_count(), 'fundify-child' ); // bumbum era _nx( i amb 'number of backers for campaign' abans del domini ?></p>
			</li>
			<?php if ( ! $campaign->is_endless() ) : ?>
			<li class="days-remaining">
				<?php if ( $campaign->days_remaining() > 0 ) : ?>
					<h3><?php echo $campaign->days_remaining(); ?></h3>
					<p><?php echo _n( 'Day to Go', 'Days to Go', $campaign->days_remaining(), 'fundify-child' ); ?></p>
				<?php else : ?>
					<h3><?php echo $campaign->hours_remaining(); ?></h3>
					<p><?php echo _n( 'Hour to Go', 'Hours to Go', $campaign->hours_remaining(), 'fundify-child' ); ?></p>
				<?php endif; ?>
			</li>
			<?php endif; ?>
		</ul>

		<div class="contribute-now">
			<?php if ( $campaign->is_active() ) : ?>
				<a href="#contribute-now" class="btn-green contribute"><?php _e( 'Contribute Now', 'fundify-child' ); ?></a>
			<?php else : ?>
				<a class="btn-green expired"><?php printf( __( '%s Expired', 'fundify-child' ), edd_get_label_singular() ); ?></a>
			<?php endif; ?>
		</div>

		<?php
			if ( ! $campaign->is_endless() ) :
				$end_date = date_i18n( get_option( 'date_format' ), strtotime( $campaign->end_date() ) );
		?>
		
		<p class="fund">
			<?php if ( 'fixed' == $campaign->type() ) : ?>
			<?php printf( __( 'This %3$s will only be funded if at least %1$s is pledged by %2$s.', 'fundify-child' ), $campaign->goal(), $end_date, strtolower( edd_get_label_singular() ) ); ?>
			<?php elseif ( 'flexible' == $campaign->type() ) : ?>
			<?php printf( __( 'All funds will be collected on %1$s.', 'fundify-child' ), $end_date ); ?>
			<?php else : ?>
			<?php printf( __( 'All pledges will be collected automatically until %1$s.', 'fundify-child' ), $end_date ); ?>
			<?php endif; ?>
		</p>
		<?php endif; ?>
	</div>
</article>
