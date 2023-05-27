<?php
/**
 * Template part for displaying front page introduction.
 *
 * @package Public News
 */

// Banner Section.
$banner_section = get_theme_mod( 'public_news_banner_section_enable', false );

if ( false === $banner_section ) {
	return;
}

$content_ids         = array();
$banner_content_type = get_theme_mod( 'public_news_banner_content_type', 'post' );

if ( $banner_content_type === 'post' ) {

	for ( $i = 1; $i <= 5; $i++ ) {
		$content_ids[] = get_theme_mod( 'public_news_banner_post_' . $i );
	}

	$args = array(
		'post_type'           => 'post',
		'post__in'            => array_filter( $content_ids ),
		'orderby'             => 'post__in',
		'posts_per_page'      => absint( 5 ),
		'ignore_sticky_posts' => true,
	);

} else {
	$cat_content_id = get_theme_mod( 'public_news_banner_category' );
	$args           = array(
		'cat'            => $cat_content_id,
		'posts_per_page' => absint( 5 ),
	);
}

$query = new WP_Query( $args );
if ( $query->have_posts() ) {
	?>
	<div id="collective_news_banner_section" class="main-banner-section style-1 adore-navigation">
		<div class="theme-wrapper">
			<div class="banner-slider">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					?>
					<div class="post-item overlay-post slider-item" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>');">
						<div class="blog-banner">
							<div class="post-overlay">
								<div class="post-item-content">
									<div class="entry-cat">
										<?php the_category( '', '', get_the_ID() ); ?>
									</div>
									<h2 class="entry-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h2>
									<ul class="entry-meta">
										<li class="post-author"> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><span class="far fa-user"></span><?php echo esc_html( get_the_author() ); ?></a></li>
										<li class="post-date"> <span class="far fa-calendar-alt"></span><?php echo esc_html( get_the_date() ); ?></li>
										<li class="post-comment"> <span class="far fa-comment"></span><?php echo absint( get_comments_number( get_the_ID() ) ); ?></li>
									</ul>
								</div>   
							</div>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</div>
<?php } ?>
