<?php

// Express List Widget.
require get_theme_file_path() . '/inc/widgets/express-list-widget.php';

// List Posts Widget.
require get_theme_file_path() . '/inc/widgets/list-posts-widget.php';

/**
 * Register Widgets
 */
function public_news_register_widgets() {

	register_widget( 'Collective_News_Express_List_Widget' );

	register_widget( 'Collective_News_List_Posts_Widget' );

}
add_action( 'widgets_init', 'public_news_register_widgets' );
