<?php
/**
 * Blog / Archive Options
 */

$wp_customize->add_section(
	'collective_news_archive_page_options',
	array(
		'title' => esc_html__( 'Blog / Archive Pages Options', 'collective-news' ),
		'panel' => 'collective_news_theme_options_panel',
	)
);

// Excerpt - Excerpt Length.
$wp_customize->add_setting(
	'collective_news_excerpt_length',
	array(
		'default'           => 15,
		'sanitize_callback' => 'collective_news_sanitize_number_range',
	)
);

$wp_customize->add_control(
	'collective_news_excerpt_length',
	array(
		'label'       => esc_html__( 'Excerpt Length (no. of words)', 'collective-news' ),
		'section'     => 'collective_news_archive_page_options',
		'settings'    => 'collective_news_excerpt_length',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 5,
			'max'  => 200,
			'step' => 1,
		),
	)
);

// Grid Column layout options.
$wp_customize->add_setting(
	'collective_news_archive_grid_column_layout',
	array(
		'default'           => 'grid-column-3',
		'sanitize_callback' => 'collective_news_sanitize_select',
	)
);

$wp_customize->add_control(
	'collective_news_archive_grid_column_layout',
	array(
		'label'   => esc_html__( 'Grid Column Layout', 'collective-news' ),
		'section' => 'collective_news_archive_page_options',
		'type'    => 'select',
		'choices' => array(
			'grid-column-2' => __( 'Column 2', 'collective-news' ),
			'grid-column-3' => __( 'Column 3', 'collective-news' ),
		),
	)
);

// Enable archive page category setting.
$wp_customize->add_setting(
	'collective_news_enable_archive_category',
	array(
		'default'           => true,
		'sanitize_callback' => 'collective_news_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	new Collective_News_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'collective_news_enable_archive_category',
		array(
			'label'    => esc_html__( 'Enable Category', 'collective-news' ),
			'settings' => 'collective_news_enable_archive_category',
			'section'  => 'collective_news_archive_page_options',
			'type'     => 'checkbox',
		)
	)
);

// Enable archive page author setting.
$wp_customize->add_setting(
	'collective_news_enable_archive_author',
	array(
		'default'           => true,
		'sanitize_callback' => 'collective_news_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	new Collective_News_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'collective_news_enable_archive_author',
		array(
			'label'    => esc_html__( 'Enable Author', 'collective-news' ),
			'settings' => 'collective_news_enable_archive_author',
			'section'  => 'collective_news_archive_page_options',
			'type'     => 'checkbox',
		)
	)
);

// Enable archive page date setting.
$wp_customize->add_setting(
	'collective_news_enable_archive_date',
	array(
		'default'           => true,
		'sanitize_callback' => 'collective_news_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	new Collective_News_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'collective_news_enable_archive_date',
		array(
			'label'    => esc_html__( 'Enable Date', 'collective-news' ),
			'settings' => 'collective_news_enable_archive_date',
			'section'  => 'collective_news_archive_page_options',
			'type'     => 'checkbox',
		)
	)
);
