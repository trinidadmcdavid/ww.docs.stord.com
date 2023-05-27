<?php
if ( ! class_exists( 'Collective_News_Express_List_Widget' ) ) {
	/**
	 * Adds Collective News Express List Widget.
	 */
	class Collective_News_Express_List_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			$express_list_widget = array(
				'classname'   => 'widget adore-widget express-list-widget style-2',
				'description' => __( 'Retrive Express List Widgets', 'public-news' ),
			);
			parent::__construct(
				'collective_news_express_list_widget',
				__( 'Collective News: Express List Widget', 'public-news' ),
				$express_list_widget
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			if ( ! isset( $args['widget_id'] ) ) {
				$args['widget_id'] = $this->id;
			}
			$express_list_title       = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
			$express_list_title       = apply_filters( 'widget_title', $express_list_title, $instance, $this->id_base );
			$viewall_button_label     = ( ! empty( $instance['view_all_button_label'] ) ) ? $instance['view_all_button_label'] : '';
			$read_more_button_label   = ( ! empty( $instance['read_more_button_label'] ) ) ? $instance['read_more_button_label'] : __( 'Read More', 'public-news' );
			$express_list_post_offset = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : '';
			$express_list_category    = isset( $instance['category'] ) ? absint( $instance['category'] ) : '';
			$viewall_button_link      = ( ! empty( $instance['view_all_button_link'] ) ) ? $instance['view_all_button_link'] : esc_url( get_category_link( $express_list_category ) );

			echo $args['before_widget'];
			?>
			<div class="widget-header">
				<?php
				if ( ! empty( $express_list_title ) ) {
					echo $args['before_title'] . esc_html( $express_list_title ) . $args['after_title'];
				}
				if ( ! empty( $viewall_button_label ) ) {
					?>
					<a href="<?php echo esc_url( $viewall_button_link ); ?>"><?php echo esc_html( $viewall_button_label ); ?></a>
				<?php } ?>
			</div>
			<div class="adore-widget-body">
				<div class="express-list-widget-wrapper">
					<?php
					$express_list_widgets_args = array(
						'post_type'      => 'post',
						'posts_per_page' => absint( 5 ),
						'offset'         => absint( $express_list_post_offset ),
						'orderby'        => 'date',
						'order'          => 'desc',
						'cat'            => absint( $express_list_category ),
					);
					$query                     = new WP_Query( $express_list_widgets_args );
					if ( $query->have_posts() ) :
						$i = 1;
						while ( $query->have_posts() ) :
							$query->the_post();
							$class = ( $i === 1 ? 'post-grid' : 'post-list' );
							?>
							<div class="post-item <?php echo esc_attr( $class ); ?>">
								<div class="post-item-image">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail(); ?>							
									</a>
								</div>
								<div class="post-item-content">
									<div class="entry-cat no-bg">
										<?php the_category( '', '', get_the_ID() ); ?>						
									</div>
									<h3 class="entry-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>  
									<ul class="entry-meta">
										<li class="post-author"> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><span class="far fa-user"></span><?php echo esc_html( get_the_author() ); ?></a></li>
										<li class="post-date"> <span class="far fa-calendar-alt"></span><?php echo esc_html( get_the_date() ); ?></li>
										<li class="post-comment"> <span class="far fa-comment"></span><?php echo absint( get_comments_number( get_the_ID() ) ); ?></li>
									</ul>
									<div class="post-exerpt">
										<p><?php echo wp_kses_post( wp_trim_words( get_the_content(), 15 ) ); ?></p>
									</div>
									<?php if ( ! empty( $read_more_button_label ) ) { ?>
										<div class="post-btn">
											<a href="<?php the_permalink(); ?>" class="btn-read-more"><?php echo esc_html( $read_more_button_label ); ?><i></i></a>
										</div>
									<?php } ?>
								</div>
							</div>
							<?php
							$i++;
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</div>
			<?php
			echo $args['after_widget'];
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			$express_list_title       = isset( $instance['title'] ) ? $instance['title'] : '';
			$viewall_button_label     = isset( $instance['view_all_button_label'] ) ? $instance['view_all_button_label'] : '';
			$viewall_button_link      = isset( $instance['view_all_button_link'] ) ? $instance['view_all_button_link'] : '';
			$read_more_button_label   = isset( $instance['read_more_button_label'] ) ? $instance['read_more_button_label'] : __( 'Read More', 'public-news' );
			$express_list_post_offset = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : '';
			$express_list_category    = isset( $instance['category'] ) ? absint( $instance['category'] ) : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Section Title:', 'public-news' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $express_list_title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'view_all_button_label' ) ); ?>"><?php esc_html_e( 'View All Button:', 'public-news' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'view_all_button_label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'view_all_button_label' ) ); ?>" type="text" value="<?php echo esc_attr( $viewall_button_label ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'view_all_button_link' ) ); ?>"><?php esc_html_e( 'View All Button URL:', 'public-news' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'view_all_button_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'view_all_button_link' ) ); ?>" type="text" value="<?php echo esc_attr( $viewall_button_link ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'read_more_button_label' ) ); ?>"><?php esc_html_e( 'Read More Button Label:', 'public-news' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'read_more_button_label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'read_more_button_label' ) ); ?>" type="text" value="<?php echo esc_attr( $read_more_button_label ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Number of posts to displace or pass over:', 'public-news' ); ?></label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" step="1" min="0" value="<?php echo absint( $express_list_post_offset ); ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Select the category to show posts:', 'public-news' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" class="widefat" style="width:100%;">
					<?php
					$categories = collective_news_get_post_cat_choices();
					foreach ( $categories as $category => $value ) {
						?>
						<option value="<?php echo absint( $category ); ?>" <?php selected( $express_list_category, $category ); ?>><?php echo esc_html( $value ); ?></option>
					<?php } ?>      
				</select>
			</p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance                           = $old_instance;
			$instance['title']                  = sanitize_text_field( $new_instance['title'] );
			$instance['view_all_button_label']  = sanitize_text_field( $new_instance['view_all_button_label'] );
			$instance['view_all_button_link']   = esc_url_raw( $new_instance['view_all_button_link'] );
			$instance['read_more_button_label'] = sanitize_text_field( $new_instance['read_more_button_label'] );
			$instance['offset']                 = (int) $new_instance['offset'];
			$instance['category']               = (int) $new_instance['category'];
			return $instance;
		}

	}
}
