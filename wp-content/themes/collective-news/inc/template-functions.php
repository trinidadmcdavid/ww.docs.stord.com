<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Collective News
 */

function collective_news_font_choices() {
	$font_family_arr     = array();
	$font_family_arr[''] = esc_html__( '--Default--', 'collective-news' );

	// Make the request.
	$request = wp_remote_get( get_theme_file_uri( 'assets/webfonts.json' ) );

	if ( is_wp_error( $request ) ) {
		return false; // Bail early.
	}
	// Retrieve the data.
	$body = wp_remote_retrieve_body( $request );
	$data = json_decode( $body );
	if ( ! empty( $data ) ) {
		foreach ( $data->items as $items => $fonts ) {
			$family_str_arr                   = explode( ' ', $fonts->family );
			$family_value                     = implode( '+', $family_str_arr );
			$font_family_arr[ $family_value ] = $fonts->family;
		}
	}

	return $font_family_arr;
}


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function collective_news_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// class for section header style.
	$classes[] = 'section-header-4';

	$classes[] = collective_news_sidebar_layout();

	return $classes;
}
add_filter( 'body_class', 'collective_news_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function collective_news_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'collective_news_pingback_header' );

/**
 * Get an array of post id and title.
 */
function collective_news_get_post_choices() {
	$choices = array( '' => esc_html__( '--Select--', 'collective-news' ) );
	$args    = array( 'numberposts' => -1 );
	$posts   = get_posts( $args );

	foreach ( $posts as $post ) {
		$id             = $post->ID;
		$title          = $post->post_title;
		$choices[ $id ] = $title;
	}

	return $choices;
	wp_reset_postdata();
}

/**
 * Get all pages for customizer Page content type.
 */
function collective_news_get_page_choices() {
	$pages      = get_pages();
	$choices    = array();
	$choices[0] = esc_html__( '--Select--', 'collective-news' );
	foreach ( $pages as $page ) {
		$choices[ $page->ID ] = $page->post_title;
	}
	return $choices;
}

/**
 * Get an array of cat id and title.
 */
function collective_news_get_post_cat_choices() {
	$choices = array( '' => esc_html__( '--Select--', 'collective-news' ) );
	$cats    = get_categories();

	foreach ( $cats as $cat ) {
		$id             = $cat->term_id;
		$title          = $cat->name;
		$choices[ $id ] = $title;
	}

	return $choices;
}

/**
 * Checks to see if we're on the homepage or not.
 */
function collective_news_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Your latest posts".
 */
function collective_news_is_latest_posts() {
	return ( is_front_page() && is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Posts page".
 */
function collective_news_is_frontpage_blog() {
	return ( is_home() && ! is_front_page() );
}

/**
 * Shows a breadcrumb for all types of pages.  This is a wrapper function for the Breadcrumb_Trail class,
 * which should be used in theme templates.
 *
 * @since  1.0.0
 * @access public
 * @param  array $args Arguments to pass to Breadcrumb_Trail.
 * @return void
 */
function collective_news_breadcrumb( $args = array() ) {
	$breadcrumb = apply_filters( 'breadcrumb_trail_object', null, $args );

	if ( ! is_object( $breadcrumb ) ) {
		$breadcrumb = new Breadcrumb_Trail( $args );
	}

	return $breadcrumb->trail();
}

/**
 * Add separator for breadcrumb trail.
 */
function collective_news_breadcrumb_trail_print_styles() {
	$breadcrumb_separator = get_theme_mod( 'collective_news_breadcrumb_separator', '/' );

	$style = '
	.trail-items li:not(:last-child):after {
		content: "' . $breadcrumb_separator . '";
	}';

	$style = apply_filters( 'collective_news_breadcrumb_trail_inline_style', trim( str_replace( array( "\r", "\n", "\t", '  ' ), '', $style ) ) );

	if ( $style ) {
		echo "\n" . '<style type="text/css" id="breadcrumb-trail-css">' . $style . '</style>' . "\n";
	}
}
add_action( 'wp_head', 'collective_news_breadcrumb_trail_print_styles' );

if ( ! function_exists( 'collective_news_sidebar_layout' ) ) {
	/**
	 * Get sidebar layout.
	 */
	function collective_news_sidebar_layout() {
		$sidebar_position      = get_theme_mod( 'collective_news_sidebar_position', 'right-sidebar' );
		$sidebar_position_post = get_theme_mod( 'collective_news_post_sidebar_position', 'right-sidebar' );
		$sidebar_position_page = get_theme_mod( 'collective_news_page_sidebar_position', 'right-sidebar' );

		if ( is_single() ) {
			$sidebar_position = $sidebar_position_post;
		} elseif ( is_page() ) {
			$sidebar_position = $sidebar_position_page;
		}

		return $sidebar_position;
	}
}

if ( ! function_exists( 'collective_news_is_sidebar_enabled' ) ) {
	/**
	 * Check if sidebar is enabled.
	 */
	function collective_news_is_sidebar_enabled() {
		$sidebar_position      = get_theme_mod( 'collective_news_sidebar_position', 'right-sidebar' );
		$sidebar_position_post = get_theme_mod( 'collective_news_post_sidebar_position', 'right-sidebar' );
		$sidebar_position_page = get_theme_mod( 'collective_news_page_sidebar_position', 'right-sidebar' );

		$sidebar_enabled = true;
		if ( is_home() || is_archive() || is_search() ) {
			if ( 'no-sidebar' === $sidebar_position ) {
				$sidebar_enabled = false;
			}
		} elseif ( is_single() ) {
			if ( 'no-sidebar' === $sidebar_position || 'no-sidebar' === $sidebar_position_post ) {
				$sidebar_enabled = false;
			}
		} elseif ( is_page() ) {
			if ( 'no-sidebar' === $sidebar_position || 'no-sidebar' === $sidebar_position_page ) {
				$sidebar_enabled = false;
			}
		}
		return $sidebar_enabled;
	}
}

/**
 * Pagination for archive.
 */
function collective_news_render_posts_pagination() {
	$is_pagination_enabled = get_theme_mod( 'collective_news_pagination_enable', true );
	if ( $is_pagination_enabled ) {
		$pagination_type = get_theme_mod( 'collective_news_pagination_type', 'default' );
		if ( 'default' === $pagination_type ) :
			the_posts_navigation();
		else :
			the_posts_pagination();
		endif;
	}
}
add_action( 'collective_news_posts_pagination', 'collective_news_render_posts_pagination', 10 );

/**
 * Pagination for single post.
 */
function collective_news_render_post_navigation() {
	the_post_navigation(
		array(
			'prev_text' => '<span>&#10229;</span> <span class="nav-title">%title</span>',
			'next_text' => '<span class="nav-title">%title</span> <span>&#10230;</span>',
		)
	);
}
add_action( 'collective_news_post_navigation', 'collective_news_render_post_navigation' );

if ( ! function_exists( 'collective_news_excerpt_length' ) ) :
	/**
	 * Excerpt length.
	 */

	function collective_news_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		$length = get_theme_mod( 'collective_news_excerpt_length', 15 );
		return $length;
	}
endif;
add_filter( 'excerpt_length', 'collective_news_excerpt_length', 999 );

if ( ! function_exists( 'collective_news_the_excerpt' ) ) :

	/**
	 * Generate excerpt.

	 * @since 1.0.0

	 * @param int     $length Excerpt length in words.
	 * @param WP_Post $post_obj WP_Post instance (Optional).
	 * @return string Excerpt.
	 */
	function collective_news_the_excerpt( $length = 0, $post_obj = null ) {

		global $post;

		if ( is_null( $post_obj ) ) {
			$post_obj = $post;
		}

		$length = absint( $length );

		if ( 0 === $length ) {
			return;
		}

		$source_content = $post_obj->post_content;

		if ( ! empty( $post_obj->post_excerpt ) ) {
			$source_content = $post_obj->post_excerpt;
		}

		$source_content  = preg_replace( '`\[[^\]]*\]`', '', $source_content );
		$trimmed_content = wp_trim_words( $source_content, $length, '&hellip;' );
		return $trimmed_content;

	}

endif;

// Add auto p to the palces where get_the_excerpt is being called.
add_filter( 'get_the_excerpt', 'wpautop' );

// Style for demo data download link
function collective_news_admin_panel_demo_data_download_link() {
     ?>
     <style type="text/css">
         p.demo-data-download-link {
             font-size: 16px;
             font-weight: 700;
             display: inline-block;
             border: 0.5px solid #dfdfdf;
             padding: 8px;
             background: #ffff;
         }
     </style>
     <?php
 }
 add_action( 'admin_enqueue_scripts', 'collective_news_admin_panel_demo_data_download_link' );

if ( ! function_exists( 'collective_news_excerpt_length_validation' ) ) {
	function collective_news_excerpt_length_validation( $validity, $value ) {
		$value = intval( $value );
		if ( empty( $value ) || ! is_numeric( $value ) ) {
			$validity->add( 'required', esc_html__( 'You must supply a valid number.', 'collective-news' ) );
		} elseif ( $value < 1 ) {
			$validity->add( 'min_no_of_words', esc_html__( 'Minimum no of words is 1', 'collective-news' ) );
		} elseif ( $value > 100 ) {
			$validity->add( 'max_no_of_words', esc_html__( 'Maximum no of words is 100', 'collective-news' ) );
		}
		return $validity;
	}
}
