<?php
/**
 * Adore Themes Customizer
 *
 * @package Public News
 *
 * Banner Section
 */

$wp_customize->add_section(
	'collective_news_banner_section',
	array(
		'title'    => esc_html__( 'Banner Section', 'public-news' ),
		'panel'    => 'collective_news_frontpage_panel',
		'priority' => 20,
	)
);

// Banner enable setting.
$wp_customize->add_setting(
	'public_news_banner_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'collective_news_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	new Public_News_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'public_news_banner_section_enable',
		array(
			'label'    => esc_html__( 'Enable Banner Section', 'public-news' ),
			'type'     => 'checkbox',
			'settings' => 'public_news_banner_section_enable',
			'section'  => 'collective_news_banner_section',
		)
	)
);

// banner content type settings.
$wp_customize->add_setting(
	'public_news_banner_content_type',
	array(
		'default'           => 'post',
		'sanitize_callback' => 'collective_news_sanitize_select',
	)
);

$wp_customize->add_control(
	'public_news_banner_content_type',
	array(
		'label'           => esc_html__( 'Content type:', 'public-news' ),
		'description'     => esc_html__( 'Choose where you want to render the content from.', 'public-news' ),
		'section'         => 'collective_news_banner_section',
		'type'            => 'select',
		'active_callback' => 'public_news_if_banner_enabled',
		'choices'         => array(
			'post'     => esc_html__( 'Post', 'public-news' ),
			'category' => esc_html__( 'Category', 'public-news' ),
		),
	)
);

for ( $i = 1; $i <= 5; $i++ ) {
	// banner post setting.
	$wp_customize->add_setting(
		'public_news_banner_post_' . $i,
		array(
			'sanitize_callback' => 'collective_news_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'public_news_banner_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Post %d', 'public-news' ), $i ),
			'section'         => 'collective_news_banner_section',
			'type'            => 'select',
			'choices'         => collective_news_get_post_choices(),
			'active_callback' => 'public_news_banner_section_content_type_post_enabled',
		)
	);

}

// banner category setting.
$wp_customize->add_setting(
	'public_news_banner_category',
	array(
		'sanitize_callback' => 'collective_news_sanitize_select',
	)
);

$wp_customize->add_control(
	'public_news_banner_category',
	array(
		'label'           => esc_html__( 'Category', 'public-news' ),
		'section'         => 'collective_news_banner_section',
		'type'            => 'select',
		'choices'         => collective_news_get_post_cat_choices(),
		'active_callback' => 'public_news_banner_section_content_type_category_enabled',
	)
);

/*========================Active Callback==============================*/
function public_news_if_banner_enabled( $control ) {
	return $control->manager->get_setting( 'public_news_banner_section_enable' )->value();
}
function public_news_banner_section_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'public_news_banner_content_type' )->value();
	return public_news_if_banner_enabled( $control ) && ( 'post' === $content_type );
}
function public_news_banner_section_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'public_news_banner_content_type' )->value();
	return public_news_if_banner_enabled( $control ) && ( 'category' === $content_type );
}
