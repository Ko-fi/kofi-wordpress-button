<?php
/**
 * Class for the Ko-fi options page
 *
 * @package kofi-wordpress-button
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Ko-fi options page class
 */
class Ko_Fi_Options {

	/**
	 * Plugin options
	 *
	 * @var array
	 */
	protected $options = array();

	/**
	 * Default settings
	 *
	 * @var array
	 */
	protected $fallbacks = array();

	/**
	 * Class constructor
	 * Set up the options and hooks
	 */
	public function __construct() {

		$this->options = Default_ko_fi_options::get();

		$this->fallbacks = get_option( $this->options['option_name'] );

		if ( false === $this->fallbacks ) {
			$this->default_fallbacks();
		}

		add_action( 'admin_init', array( $this, 'set_options' ) );
		add_action( 'admin_menu', array( $this, 'menu' ) );
	}

	/**
	 * Set the default settings
	 */
	public function default_fallbacks() {
		update_option( $this->options['option_name'], $this->options['defaults'] );
		$this->fallbacks = $this->options['defaults'];
	}

	/**
	 * Add the settings page to the admin menu
	 */
	public function menu() {
		add_options_page(
			$this->options['page_title'],
			$this->options['menu_title'],
			$this->options['capability'],
			$this->options['menu_slug'],
			array( $this, 'get_page_html' )
		);
	}

	/**
	 * Render the settings page
	 */
	public function get_page_html() {
		?>
		<div class="wrap ko-fi-settings">
			<style>
				.ko-fi-settings-page-description,
				.ko-fi-settings-section-description {
					font-size: 1.1em;
				}
			</style>
			<h1><?php echo esc_html( $this->options['page_title'] ); ?></h1>
			<section class="ko-fi-settings-page-description"><?php echo wp_kses_post( wpautop( $this->options['page_description'] ) ); ?></section>
			<form method="post" action="options.php">
				<?php
				settings_fields( $this->options['option_name'] );
				do_settings_sections( $this->options['menu_slug'] );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register the settings for the settings page
	 */
	public function set_options() {

		register_setting(
			$this->options['option_name'],
			$this->options['option_name']
		);

		foreach ( $this->options['sections'] as $section ) {

			add_settings_section(
				$section['slug'],
				$section['title'],
				function () use ( $section ) {
					echo '<section class="ko-fi-settings-section-description">' . esc_html( $section['section_description'] ) . '</section>';
				},
				$this->options['page_name']
			);

			foreach ( $section['fields'] as $field ) {

				$id = sprintf(
					'%s[%s_%s]',
					$this->options['page_name'],
					$section['slug_prefix'],
					$field['slug']
				);

				$selector = sprintf(
					'%s_%s_%s',
					$this->options['page_name'],
					$section['slug_prefix'],
					$field['slug']
				);

				$placeholder = empty( $field['placeholder'] ) ? '' : $field['placeholder'];
				$field_value = isset( $this->fallbacks[ $section['slug_prefix'] . '_' . $field['slug'] ] ) ? $this->fallbacks[ $section['slug_prefix'] . '_' . $field['slug'] ] : false;

				add_settings_field(
					$id,
					sprintf(
						'<label for="%s">%s</label>',
						esc_attr( $id ),
						esc_html( $field['title'] )
					),
					array( $this, 'get_field' ),
					$this->options['page_name'],
					$section['slug'],
					array(
						'option_type' => $field['type'],
						'option_id'   => $id,
						'description' => empty( $field['description'] ) ? '' : $field['description'],
						'label'       => empty( $field['label'] ) ? '' : $field['label'],
						'options'     => isset( $field['options'] ) ? $field['options'] : false,
						'value'       => $field_value,
						'selector'    => $selector,
						'placeholder' => $placeholder,
					)
				);
			}
		}
	}

	/**
	 * Get a specific plugin setting
	 */
	public function get() {
		return get_option( $this->options['option_name'] );
	}

	/**
	 * Wrapper function for getting a settings field
	 *
	 * @param array $args Arguments to pass through.
	 */
	public function get_field( $args ) {
		call_user_func( array( $this, $args['option_type'] ), $args );
		if ( ! empty( $args['description'] ) ) {
			?>
			<p class="description"><?php echo esc_html( $args['description'] ); ?></p>
			<?php
		}
	}

	/**
	 * Render a text input field
	 *
	 * @param array $args Field arguments.
	 */
	public function text( $args ) {
		printf(
			'<input class="regular-text" id="%1$s" name="%2$s" type="text" value="%3$s" placeholder="%4$s"/>',
			esc_attr( $args['selector'] ),
			esc_attr( $args['option_id'] ),
			esc_attr( $args['value'] ),
			esc_attr( $args['placeholder'] )
		);
	}

	/**
	 * Render a color input field
	 *
	 * @param array $args Field arguments.
	 */
	public function color( $args ) {
		echo Ko_Fi::get_jscolor( $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Render a number input field
	 *
	 * @param array $args Field arguments.
	 */
	public function number( $args ) {
		printf(
			'<input class="regular-text" id="%1$s" name="%2$s" type="number" value="%3$s" min="%4$s" max="%5$s" step="%6$s" />',
			esc_attr( $args['selector'] ),
			esc_attr( $args['option_id'] ),
			esc_attr( $args['value'] ),
			intval( $args['options']['min'] ),
			intval( $args['options']['max'] ),
			intval( $args['options']['step'] )
		);
	}

	/**
	 * Render a textarea field
	 *
	 * @param array $args Field arguments.
	 */
	public function textarea( $args ) {
		printf(
			'<textarea class="all-options" id="%1$s" name="%2$s" rows="5" style="width: 350px;">%3$s</textarea>',
			esc_attr( $args['selector'] ),
			esc_attr( $args['option_id'] ),
			esc_html( $args['value'] )
		);
	}

	/**
	 * Render a dropdown field
	 *
	 * @param array $args Field arguments.
	 */
	public function select( $args ) {
		printf( '<select id="%1$s" name="%2$s">', esc_attr( $args['selector'] ), esc_attr( $args['option_id'] ) );
		foreach ( $args['options']['list'] as $value => $label ) {
			printf(
				'<option value="%s"%s>%s</option>',
				esc_attr( $value ),
				selected( $args['value'], $value, false ),
				esc_attr( $label )
			);
		}
		printf( '</select>' );
	}

	/**
	 * Render a single checkbox field
	 * Suitable for true/false options such as T&C
	 *
	 * @param array $args Field arguments.
	 */
	public function checkbox( $args ) {
		if ( ! empty( $args['label'] ) ) :
			printf(
				'<label><input id="%1$s" name="%2$s" type="checkbox" value="true"%3$s /> %4$s</label>',
				esc_attr( $args['selector'] ),
				esc_attr( $args['option_id'] ),
				checked( $args['value'], 'true', false ),
				esc_html( $args['label'] )
			);
		else :
			printf(
				'<input id="%1$s" name="%2$s" type="checkbox" value="true"%3$s />',
				esc_attr( $args['selector'] ),
				esc_attr( $args['option_id'] ),
				checked( $args['value'], 'true', false )
			);
		endif;
	}

	/**
	 * Render a list of checkboxes
	 *
	 * @param array $args Field arguments.
	 */
	public function checkbox_list( $args ) {
		foreach ( $args['options']['list'] as $value => $label ) {
			$is_checked = ( isset( $args['value'][ $value ] ) && $args['value'][ $value ] );
			printf(
				'<label for="%1$s"><input id="%1$s" name="%2$s" type="checkbox" value="true"%3$s /> %4$s</label><br />',
				esc_attr( $args['selector'] ),
				esc_attr( "{$args['option_id']}[{$value}]" ),
				checked( $is_checked, true, false ),
				esc_html( $label )
			);
		}
	}
}
