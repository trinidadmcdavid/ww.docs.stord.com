<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Collective News
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', 'single' );

		the_post_navigation(
			array(
				'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'collective-news' ) . '</span> <span class="nav-title">%title</span>',
				'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'collective-news' ) . '</span> <span class="nav-title">%title</span>',
			)
		);

		$related_posts_enable = get_theme_mod( 'collective_news_enable_single_post_related_posts', true );

		if ( $related_posts_enable === true ) :

			if ( is_singular( 'post' ) ) {
				$cat_content_id = get_the_category( $post->ID )[0]->term_id;
				$args           = array(
					'cat'            => $cat_content_id,
					'posts_per_page' => 3,
					'post__not_in'   => array( $post->ID ),
					'orderby'        => 'rand',
				);

				$query = new WP_Query( $args );

				if ( $query->have_posts() ) :
					$related_title = get_theme_mod( 'collective_news_related_posts_title', __( 'Related Posts', 'collective-news' ) );
					?>
					<div class="related-posts">
						<h2><?php echo esc_html( $related_title ); ?></h2>
						<div class="theme-archive-layout grid-layout grid-column-3">
							<?php
							while ( $query->have_posts() ) :
								$query->the_post();
								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<div class="post-item post-grid">
										<div class="post-item-image">
											<?php collective_news_post_thumbnail(); ?>
										</div>
										<div class="post-item-content">
											<div class="entry-cat no-bg">
												<?php the_category( '', '', get_the_ID() ); ?>
											</div>
											<?php
											the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
											?>
											<ul class="entry-meta">
												<li class="post-author"> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></li>
												<li class="post-date"> <span class="far fa-calendar-alt"></span><?php echo esc_html( get_the_date() ); ?></li>
												<li class="post-comment"> <span class="far fa-comment"></span><?php echo absint( get_comments_number( get_the_ID() ) ); ?></li>
											</ul>
											<div class="post-content">
												<?php the_excerpt(); ?>
											</div><!-- post-content -->
										</div>
									</div>
								</article>
								<?php
							endwhile;
							wp_reset_postdata();
							?>
						</div>
					</div>
					<?php
				endif;
			}

		endif;

				// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
	endif;

		endwhile; // End of the loop.
	?>

	</main><!-- #main -->

	<?php

	if ( collective_news_is_sidebar_enabled() ) {
		get_sidebar();
	}

	get_footer();
