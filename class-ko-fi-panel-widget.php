<?php
/**
 * Widget class for donation panel
 *
 * @package kofi-wordpress-button
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Widget class for donation panel
 */
class Ko_Fi_Panel_Widget extends WP_Widget {

	/**
	 * Class constructor
	 */
	public function __construct() {
		$args = array(
			'classname'   => 'ko-fi-panel-widget',
			'description' => __( 'A Ko-Fi donation panel for your website!', 'ko-fi-button' ),
		);
		parent::__construct( 'ko_fi_panel_widget', __( 'Ko-fi Donation Panel', 'ko-fi-button' ), $args );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args Widget args.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget.
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $instance['title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( isset( $instance['code'] ) && ! empty( $instance['code'] ) ) {
			$code = $instance['code'];
		} else {
			$code = Ko_Fi::$options['coffee_code'];
		}

		echo Ko_Fi::get_panel_embed_code( array( 'code' => $code ), $args['widget_id'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Outputs the options form in the admin
	 *
	 * @param array $instance The widget options.
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$code  = isset( $instance['code'] ) ? $instance['code'] : Ko_Fi::$options['coffee_code'];
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'ko-fi-button' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'code' ) ); ?>"><?php esc_html_e( 'Username:', 'ko-fi-button' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'code' ) ); ?>" type="text" value="<?php echo esc_attr( $code ); ?>">
		</p>
		<?php
	}

	/**
	 * Updating widget replacing old instances with new
	 *
	 * @param array $new_instance Updated widget instance.
	 * @param array $old_instance Previous widget instance.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['code']  = ( ! empty( $new_instance['code'] ) ) ? wp_strip_all_tags( $new_instance['code'] ) : '';
		return $instance;
	}
}
