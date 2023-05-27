<?php

// upgrade to pro.
require get_theme_file_path() . '/inc/customizer/upgrade-to-pro/class-customize.php';

function public_news_customize_register( $wp_customize ) {

	class Public_News_Toggle_Checkbox_Custom_control extends WP_Customize_Control {
		public $type = 'toogle_checkbox';

		public function render_content() {
			?>
			<div class="checkbox_switch">
				<div class="onoffswitch">
					<input type="checkbox" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" class="onoffswitch-checkbox" value="<?php echo esc_attr( $this->value() ); ?>" 
					<?php
					$this->link();
					checked( $this->value() );
					?>
					>
					<label class="onoffswitch-label" for="<?php echo esc_attr( $this->id ); ?>"></label>
				</div>
				<span class="customize-control-title onoffswitch_label"><?php echo esc_html( $this->label ); ?></span>
				<p><?php echo wp_kses_post( $this->description ); ?></p>
			</div>
			<?php
		}
	}

	// customizer section.
	require get_theme_file_path() . '/inc/customizer/frontpage-customizer/banner.php';

}
add_action( 'customize_register', 'public_news_customize_register' );

function public_news_custom_control_scripts() {
	wp_enqueue_style( 'public-news-customize-controls', get_theme_file_uri() . '/customize-controls.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'public_news_custom_control_scripts' );
