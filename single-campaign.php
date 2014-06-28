<?php
/**
 * The Template for displaying all single campaigns.
 *
 * @package Fundify
 * @since Fundify 1.0
 */

global $campaign, $wp_embed;

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); $campaign = atcf_get_campaign( $post->ID ); ?>

		<?php locate_template( array( 'campaign/title.php' ), true ); ?>
		
		<div id="content" class="post-details">
			<div class="container">
				
				<?php do_action( 'atcf_campaign_before', $campaign ); ?>
				
				<?php locate_template( array( 'searchform-campaign.php' ), true ); ?>
				<?php locate_template( array( 'campaign/campaign-sort-tabs.php' ), true ); ?>

				<?php // bumbum: canvio el markup de div...
				//locate_template( array( 'campaign/project-details.php' ), true ); ?>

				<aside id="sidebar">
					<?php locate_template( array( 'campaign/project-details.php' ), true ); //bumbum ?>
					<?php locate_template( array( 'campaign/meta.php' ), true ); //bumbum ?>
					<?php locate_template( array( 'campaign/share.php' ), true ); //bumbum ?>
					
					
					
					<?php //locate_template( array( 'campaign/author-info.php' ), true ); //bumbum ?>

					<div id="contribute-now" class="single-reward-levels">
						<?php 
							if ( $campaign->is_active() ) :
								echo edd_get_purchase_link( array( 
									'download_id' => $post->ID,
									'class'       => '',
									'price'       => false,
									'text'        => __( 'Contribute Now', 'fundify' )
								) ); 
							else : // Inactive, just show options with no button
								atcf_campaign_contribute_options( edd_get_variable_prices( $post->ID ), 'checkbox', $post->ID );
							endif;
						?>					
					</div>
					
					<?php locate_template( array( 'campaign/author-info.php' ), true ); //bumbum ?>
					
					<div class="widget-area" role="complementary">
						<div class="sidebar-widgets">
							<?php dynamic_sidebar(1); ?>
						</div>
						<?php do_action( 'after_sidebar' ); ?>
					</div>
					
				</aside>

				<div id="main-content">
					<?php //locate_template( array( 'campaign/meta.php' ), true ); // bumbum ?>
					<?php //locate_template( array( 'campaign/share.php' ), true ); // bumbum ?>
					
					
					<?php if ( $campaign->video() ) : //TODO bumbum, afegir video ?>
						<div class="image">
							<div class="video-container">
							<?php echo $wp_embed->run_shortcode( '[embed]' . $campaign->video() . '[/embed]' ); ?>
							</div>
						</div>
					<?php else : ?>
						<?php //the_post_thumbnail( 'blog' ); // bumbum?>
					<?php endif; // bumbum ?>
					
					
					<div class="entry-content inner campaign-tabs">
						<div id="description">
							<?php the_content(); ?>
						</div>

						<?php locate_template( array( 'campaign/updates.php' ), true ); ?>

						<?php comments_template(); ?>

						<?php locate_template( array( 'campaign/backers.php' ), true ); ?>
					</div>
				</div>

			</div>
		</div>

	<?php endwhile; ?>

<?php get_footer(); ?>
