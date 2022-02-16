<?php
/**
 * Widget class for Ko-Fi button
 *
 * @package kofi-wordpress-button
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Ko fi widget
 */
class ko_fi_widget extends WP_Widget
{
	public function __construct()
	{
		$widget_ops = [
			'classname'   => 'ko_fi_widget',
			'description' => 'A ko-fi button for your website!',
		];
		parent::__construct('ko_fi_widget', 'Ko-fi Button', $widget_ops);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget($args, $instance)
	{
		// outputs the content of the widget.
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $instance['title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( ! empty( $instance['description'] ) ) {
			printf(
				'<p>%1$s</p>',
				esc_html( $instance['description'] )
			);
		}

		$new_instance = $this->get_new_instance();

		if ( ! empty($instance['description']) ) {

			$new_instance = [
				'title' => $instance['title'],
				'text' => $instance['text'],
				'color' => $instance['color'],
				'hyperlink' => $instance['hyperlink'],
				'code' => $instance['code'],
				'button_alignment' => $instance['button_alignment']
			];
		}
	  
		echo Ko_Fi::get_button_embed_code( $new_instance, $args[ 'widget_id' ] );
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 *
	 * @return string|void
	 */
	public function form($instance)
	{        
		$current_opts = $this->get_options();
		if(empty($instance))
		{            
			$instance = $this->get_new_instance();
		}

		$title = esc_html( $instance['title'] );
		$description = esc_html( $instance['description'] );
		$text = esc_attr( $instance['text'] );
		$hyperlink = esc_attr( $instance['hyperlink'] );
		$color = esc_attr( $instance['color'] );
		$code = esc_attr( $current_opts['coffee_code'] );
		$button_alignment = esc_attr( $instance['button_alignment'] );

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'code' ) ); ?>"><?php esc_html_e( 'Page Name or ID:' ); ?></label>
			<input class="widefat" readonly id="<?php echo esc_attr( $this->get_field_id( 'code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'code' ) ); ?>" type="text" value="<?php echo esc_attr( $code ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Button text:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'color' ) ); ?>"><?php esc_html_e( 'Button (hex)color:' ); ?></label>
			<?php
			$color_args = [
				'option_id' => $this->get_field_id('color'),
				'name' => $this->get_field_name('color'),
				'value' => $color,
				'options' => [
					'hash' => 'true'
				]
			];
			echo Ko_Fi::get_jscolor($color_args);
			?>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Description:' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" rows="5" type="text"><?php echo esc_textarea( $description ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hyperlink' ) ); ?>"><?php esc_html_e( 'Text link only?' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'hyperlink' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hyperlink' ) ); ?>" type="checkbox" value="true" <?php checked( $hyperlink, 'true' ); ?>>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'button_alignment' ) ); ?>"><?php esc_html_e( 'Button Alignment' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'button_alignment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_alignment' ) ); ?>">
				<option value="left" <?php selected( $button_alignment, 'left' ); ?>>Left</option>
				<option value="centre" <?php selected( $button_alignment, 'centre' ); ?>>Centre</option>
				<option value="right" <?php selected( $button_alignment, 'right' ); ?>>Right</option>
			</select>
		</p>

		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options.
	 * @param array $old_instance The previous options.
	 *
	 * @return array|void
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved.
		$old_instance = array_merge( $old_instance, $new_instance );

		if ( empty( $old_instance ) ) {
			$new_instance = $this->get_new_instance();
		}

		$instance = array();
		$defaults = Default_ko_fi_options::get()['defaults'];

		$instance['title']            = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['description']      = ( ! empty( $new_instance['description'] ) ) ? wp_strip_all_tags( $new_instance['description'] ) : '';
		$instance['text']             = ( ! empty( $new_instance['text'] ) ) ? wp_strip_all_tags( $new_instance['text'] ) : '';
		$instance['hyperlink']        = ( ! empty( $new_instance['hyperlink'] ) ) ? wp_strip_all_tags( $new_instance['hyperlink'] ) : false;
		$instance['color']            = ( ! empty( $new_instance['color'] ) ) ? wp_strip_all_tags( $new_instance['color'] ) : $defaults['coffee_color'];
		$instance['code']             = ( ! empty( $new_instance['code'] ) ) ? wp_strip_all_tags( $new_instance['code'] ) : '';
		$instance['button_alignment'] = ( ! empty( $new_instance['button_alignment'] ) ) ? wp_strip_all_tags( $new_instance['button_alignment'] ) : '';

		return $instance;
	}


	/**
	 * Get the current options from the settings
	 *
	 * @return array
	 */
	private function get_new_instance() {
	
		$current_opts = $this->get_options();

		$instance = [
			'description' => $current_opts['coffee_description'],
			'title' => $current_opts['coffee_title'],
			'text' => $current_opts['coffee_text'],
			'color' => $current_opts['coffee_color'],
			'hyperlink' => !empty( $current_opts['coffee_hyperlink'] ) ? $current_opts['coffee_hyperlink'] : false,
			'code' => $current_opts['coffee_code'],
			'button_alignment' => $current_opts['coffee_button_alignment']
		];

		return $instance;
	}
	
	/**
	 * Get the current plugin options and if not present use the default values.
	 * 
	 * @return array
	 */
	private function get_options() {

		$defaults = Default_ko_fi_options::get()['defaults'];
		$current_opts = get_option( 'ko_fi_options', $defaults );

		//ensure that any new option values are picked up
		$current_opts = array_merge( $defaults, $current_opts );

		return $current_opts;
	}
}
