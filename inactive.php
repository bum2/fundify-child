<?php
/**
 * Template Name: Inactive
 *
 * This should be used in conjunction with the Fundify plugin.
 *
 * @package Fundify
 * @since Fundify 1.3
 */

$thing_args = array(
	'post_type' => array( 'download' )
);


$things = new WP_Query( $thing_args );

get_header(); 
?>

	<div class="title pattern-<?php echo rand(1,4); ?>">
		<div class="container">
			<h1><?php the_title(); ?></h1>
		</div>
		<!-- / container -->
	</div>

	<div id="content">
		<div class="container">
			
			<div id="projects">
				<section>
						
					<?php if ( $things->have_posts() ) : ?>

						<?php while ( $things->have_posts() ) : $things->the_post(); 
							
							//bumbum: retrieve $campaign to filter inactive projects using method is_active()
							$campaign = atcf_get_campaign( $post );
							if( !$campaign->is_active() ) :
								 get_template_part( 'content', 'campaign' ); 
							endif;
						
						endwhile; ?>

						<?php do_action( 'fundify_loop_after' ); ?>

					<?php else : ?>

						<?php get_template_part( 'no-results', 'index' ); ?>

					<?php endif; ?>
				</section>
			</div>
		</div>
		<!-- / container -->
	</div>
	<!-- / content -->

<?php get_footer(); ?>
