<?php
/**
 * Public News functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Public News
 */

add_theme_support( 'title-tag' );

add_theme_support( 'automatic-feed-links' );

add_theme_support( 'register_block_style' );

add_theme_support( 'register_block_pattern' );

add_theme_support( 'responsive-embeds' );

add_theme_support( 'wp-block-styles' );

add_theme_support( 'align-wide' );

add_theme_support(
	'html5',
	array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	)
);

add_theme_support(
	'custom-logo',
	array(
		'height'      => 250,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
	)
);

if ( ! function_exists( 'public_news_setup' ) ) :
	function public_news_setup() {
		/*
		* Make child theme available for translation.
		* Translations can be filed in the /languages/ directory.
		*/
		load_child_theme_textdomain( 'public-news', get_stylesheet_directory() . '/languages' );
	}
endif;
add_action( 'after_setup_theme', 'public_news_setup' );

if ( ! function_exists( 'public_news_enqueue_styles' ) ) :
	/**
	 * Enqueue scripts and styles.
	 */
	function public_news_enqueue_styles() {
		$parenthandle = 'collective-news-style';
		$theme        = wp_get_theme();

		wp_enqueue_style(
			$parenthandle,
			get_template_directory_uri() . '/style.css',
			array(
				'collective-news-fonts',
				'collective-news-slick-style',
				'collective-news-fontawesome-style',
				'collective-news-blocks-style',
			),
			$theme->parent()->get( 'Version' )
		);

		wp_enqueue_style(
			'public-news-style',
			get_stylesheet_uri(),
			array( $parenthandle ),
			$theme->get( 'Version' )
		);

	}

endif;

add_action( 'wp_enqueue_scripts', 'public_news_enqueue_styles' );

function public_news_load_custom_wp_admin_style() {
	?>
	<style type="text/css">

		.ocdi p.demo-data-download-link {
			display: none !important;
		}

	</style>

	<?php
}
add_action( 'admin_enqueue_scripts', 'public_news_load_custom_wp_admin_style' );

// Style for demo data download link
function public_news_admin_panel_demo_data_download_link() {
	?>
	 <style type="text/css">
		 p.public-news-demo-data-download-link {
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
 add_action( 'admin_enqueue_scripts', 'public_news_admin_panel_demo_data_download_link' );


require get_theme_file_path() . '/inc/customizer.php';

// Widgets.
require get_theme_file_path() . '/inc/widgets/widgets.php';

// One Click Demo Import after import setup.
if ( class_exists( 'OCDI_Plugin' ) ) {
	require get_theme_file_path() . '/inc/demo-import.php';
}
