<?php
/**
 * Template Name: Front Page (carousel)
 *
 * This should be used in conjunction with the Fundify plugin.
 *
 * @package Fundify
 * @since Fundify 1.0
 */

global $wp_query;

include_once( ABSPATH . 'wp-content/plugins/appthemer-crowdfunding/includes/class-campaign.php' );
include_once( ABSPATH . 'wp-content/plugins/appthemer-crowdfunding/includes/theme-stuff.php' );

get_header(); 
?>

	<?php if ( null == fundify_theme_mod( 'hero_slider' ) ) : ?>
	<div id="home-page-featured">
		<?php
			if ( fundify_is_crowdfunding()  ) :
				$featured = new ATCF_Campaign_Query( array( 
					'posts_per_page' => 'grid' == fundify_theme_mod( 'hero_style' ) ? apply_filters( 'fundify_hero_campaign_grid', 24 ) : 1 //,
					//'meta_query'     => array(
					//	array(
					//		'key'     => '_campaign_featured',
					//		'value'   => 1,
					//		'compare' => '=',
					//		'type'    => 'numeric'
					//	)
					//)
				) ); 
			else :
				$featured = new WP_Query( array( 
					'posts_per_page' => 'grid' == fundify_theme_mod( 'hero_style' ) ? apply_filters( 'fundify_hero_campaign_grid', 24 ) : 1
				) ); 
			endif; 
		?>
		<?php if ( 'grid' == fundify_theme_mod( 'hero_style' ) ) : ?>
			<?php for ( $i = 0; $i < 1; $i++ ) : shuffle( $featured->posts ); ?>
			<ul id="carousel">
				<?php while ( $featured->have_posts() ) : $featured->the_post();
					//bumbum: get campaign to use method is_active and hide inactive
					$campaign = atcf_get_campaign( $post );
					if( $campaign->is_active() ) : ?>
						<li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog'); ?><span class="caption"><?php the_title(); ?></span></a></li>
				<?php endif;
				endwhile; ?>
			</ul>
			<?php endfor; ?>
			
			<?php wp_register_script( 'carouFredSel', get_stylesheet_directory_uri().'/js/jquery.carouFredSel-6.2.1-packed.js', ['jquery'], '6.2.1' );
			      wp_enqueue_script( 'carouFredSel');
			 ?>
			
			<script type="text/javascript" >
				jQuery(document).ready(function() {
				    // Using default configuration
				    jQuery('#carousel').carouFredSel({
				        items               : 3,
				        direction           : "left",
				        scroll : {
				            items           : 1,
				            easing          : "swing",
				            duration        : 700,                         
				            pauseOnHover    : true
				        }                   
				    });
				});

				// Positioning image Captions
				jQuery(".caption").each(function(i){
					var h = 215 - jQuery(this).height();
					jQuery(this).css('margin-top', h);
				});
					
			</script>
		<?php else : ?>
			<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>
				<?php $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'fullsize' ); ?>
				<a href="<?php the_permalink(); ?>" class="home-page-featured-single"><img src="<?php echo $thumbnail[0]; ?>" /></a>
			<?php endwhile; ?>
		<?php endif; ?>

		<h1>
			<?php 
				$string = fundify_theme_mod( 'hero_text' ); 
				$lines = explode( "\n", $string );
			?>
			<span><?php echo implode( '</span><br /><span>', $lines ); ?></span>
		</h1>
		<!-- / container -->
	</div>
	<?php else : ?>
		<?php echo do_shortcode( fundify_theme_mod( 'hero_slider' ) ); ?>
	<?php endif; ?>

	<div id="content">
		<div class="container">
			
			<?php locate_template( array( 'searchform-campaign.php' ), true ); ?>
			<?php locate_template( array( 'content-campaign-sort.php' ), true ); ?>

			<div id="projects">
				<section>
					<?php 
						if ( fundify_is_crowdfunding()  ) :
							$wp_query = new ATCF_Campaign_Query( array(
								'paged' => ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 )
							) );
						else :
							$wp_query = new WP_Query( array(
								'posts_per_page' => get_option( 'posts_per_page' ),
								'paged'          => ( get_query_var('page') ? get_query_var('page') : 1 )
							) );
						endif;

						if ( $wp_query->have_posts() ) :
					?>

						<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
							//bumbum: get campaign to use method is_active and hide inactive
                                        		$campaign = atcf_get_campaign( $post );
                                        		if( $campaign->is_active() ) :  ?>
								<?php get_template_part( 'content', fundify_is_crowdfunding() ? 'campaign' : 'post' ); ?>
						<?php 	endif;
						      endwhile; ?>

					<?php else : ?>

						<?php get_template_part( 'no-results', 'index' ); ?>

					<?php endif; ?>
				</section>

				<?php do_action( 'fundify_loop_after' ); ?>
			</div>
		</div>
		<!-- / container -->
	</div>
	<!-- / content -->

<?php get_footer(); ?>
