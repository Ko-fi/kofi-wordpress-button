<?php
/**
 * Main Ko-Fi plugin class
 *
 * @package kofi-wordpress-button
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Main Ko-fi plugin class
 */
class Ko_Fi {

	/**
	 * Plugin options
	 *
	 * @var array
	 */
	public static $options = array();

	/**
	 * Initialise the class
	 */
	public static function init() {
		add_action( 'widgets_init', array( __CLASS__, 'widget' ) );
		add_action( 'init', array( __CLASS__, 'register_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_scripts' ), 9 );
		add_action( 'wp_head', array( __CLASS__, 'maybe_display_floating_button' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'register_posts_meta_box' ) );
		add_action( 'save_post', array( __CLASS__, 'save_post_meta' ), 10, 2 );
		add_action( 'rest_api_init', array( __CLASS__, 'prevent_floating_button_displaying_on_widget_previews' ) );

		add_shortcode( 'kofi', array( __CLASS__, 'kofi_shortcode' ) );

		require_once 'class-default-ko-fi-options.php';
		require_once 'class-ko-fi-options.php';

		self::$options = ( new Ko_Fi_Options() )->get();
		add_filter( 'plugin_action_links', array( __CLASS__, 'add_action_links' ), 10, 2 );
		add_filter( 'plugin_row_meta', array( __CLASS__, 'add_row_meta' ), 10, 2 );
		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );
	}

	/**
	 * Add extra links to the plugin on the plugins list
	 *
	 * @param array  $actions Current list of actions.
	 * @param string $plugin_file Plugin file name.
	 * @return array
	 */
	public static function add_action_links( $actions, $plugin_file ) {
		$plugin = trailingslashit( basename( dirname( __FILE__ ) ) ) . 'Ko_fi.php';

		if ( $plugin === $plugin_file ) {

			$settings_url = sprintf(
				'<a href="%1$s">%2$s</a>',
				menu_page_url( Default_ko_fi_options::get()['menu_slug'], false ),
				__( 'Settings', 'ko-fi-button' )
			);
			$plugin_links = array( 'settings' => $settings_url );

			$actions = array_merge( $plugin_links, $actions );
		}

		return $actions;
	}

	/**
	 * Add extra links to the plugin meta
	 *
	 * @param array  $links Current list of actions.
	 * @param string $plugin_file Plugin file name.
	 * @return array
	 */
	public static function add_row_meta( $links, $plugin_file ) {
		$plugin = trailingslashit( basename( dirname( __FILE__ ) ) ) . 'Ko_fi.php';

		if ( $plugin === $plugin_file ) {

			$links[] = sprintf(
				'<a href="%1$s" target="_blank" rel="noopener">%2$s</a>',
				'https://help.ko-fi.com/hc/en-us/articles/115004002614-Adding-a-Ko-fi-Button-to-your-WordPress-site-or-blog',
				__( 'Getting started', 'ko-fi-button' )
			);
		}

		return $links;
	}

	/**
	 * Register any custom scripts and styles we'll need
	 */
	public static function register_scripts() {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$dir_url     = plugin_dir_url( __FILE__ );
		$plugin_data = get_plugin_data( __FILE__ );
		wp_register_script( 'extra', $dir_url . 'extra.js', array( 'jquery' ), $plugin_data['Version'], true );
		wp_register_script( 'ko-fi-button-widget', 'https://storage.ko-fi.com/cdn/widget/Widget_2.js', array( 'jquery' ), $plugin_data['Version'], true );
		wp_register_script( 'ko-fi-button', trailingslashit( $dir_url ) . 'js/widget.js', array( 'jquery', 'ko-fi-button-widget' ), $plugin_data['Version'], true );
		wp_register_script( 'ko-fi-floating-button', 'https://storage.ko-fi.com/cdn/scripts/overlay-widget.js', array( 'jquery' ), $plugin_data['Version'], true );
	}

	/**
	 * Enqueue scripts for the admin
	 */
	public static function enqueue_admin_scripts() {
		wp_enqueue_script( 'extra' );
		// Color picker.
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}

	/**
	 * Instantiate the widgets
	 */
	public static function widget() {
		require_once 'class-ko-fi-button-widget.php';
		register_widget( 'Ko_Fi_Button_Widget' );
		require_once 'class-ko-fi-panel-widget.php';
		register_widget( 'Ko_Fi_Panel_Widget' );

	}

	/**
	 * Add Shortcode
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function kofi_shortcode( $atts ) {
		// Attributes.
		$atts = shortcode_atts(
			array(
				'text'  => self::get_plugin_option( 'coffee_text' ),
				'color' => self::get_plugin_option( 'coffee_color' ),
				'type'  => 'button',
				'code'  => self::get_plugin_option( 'coffee_code' ),
			),
			$atts
		);

		// Return custom embed code.
		if ( 'button' === $atts['type'] ) {
			return self::get_button_embed_code( $atts );
		} elseif ( 'panel' === $atts['type'] ) {
			return self::get_panel_embed_code( $atts );
		}
	}

	/**
	 * Get the input markup for a color picker
	 *
	 * @param array $args Arguments to pass in.
	 */
	public static function get_jscolor( $args ) {
		$value = ! empty( $args['value'] ) ? '#' . ltrim( $args['value'], '#' ) : $args['value'];
		echo sprintf(
			'<input class="jscolor"  id="%1$s" name="%2$s" value="%3$s" />',
			esc_attr( $args['option_id'] ),
			esc_attr( empty( $args['name'] ) ? $args['option_id'] : $args['name'] ),
			esc_attr( $value )
		);
	}

	/**
	 * Get the embed code for the donate button
	 *
	 * @param array  $atts Settings to pass to the button code.
	 * @param string $widget_id Widget ID, if called by the Ko-fi widget.
	 */
	public static function get_button_embed_code( $atts, $widget_id = '' ) {
		$settings = wp_parse_args( $atts, self::$options );
		foreach ( $atts as $key => $value ) {
			switch ( $key ) {
				case 'title':
					$key = 'coffee_title';
					break;
				case 'text':
					$key = 'coffee_text';
					break;
				case 'hyperlink':
					$key = 'coffee_hyperlink';
					break;
				case 'color':
					$key   = 'coffee_color';
					$value = '#' . ltrim( $value, '#' );
					break;
				case 'code':
					$key = 'coffee_code';
					if ( empty( $value ) ) {
						$value = self::sanitise_username( self::get_plugin_option( 'coffee_code' ) );
					} else {
						$value = self::sanitise_username( $value );
					}
					break;
				case 'button_alignment':
					$key = 'coffee_button_alignment';
					break;
			}

			$settings[ $key ] = $value;
		}

		$style_registry = array(
			'left'   => 'float: none; text-align: left;',
			'right'  => 'float: right; text-align: left;',
			'centre' => 'width: 100%; text-align: center;',
		);

		$btn_container_style = $style_registry[ $settings['coffee_button_alignment'] ];

		if ( ! empty( $settings['coffee_hyperlink'] ) && $settings['coffee_hyperlink'] ) {
			return sprintf(
				'<div style="%1$s" class="ko-fi-button-link"><div class="btn-container"><a href="http://www.ko-fi.com/%2$s">%3$s</a></div></div>',
				esc_attr( $btn_container_style ),
				esc_attr( $settings['coffee_code'] ),
				esc_attr( wp_strip_all_tags( $settings['coffee_text'] ) )
			);
		} else {

			$html_variable_name = str_replace( '-', '_', $widget_id );
			if ( empty( $html_variable_name ) ) {
				$html_variable_name = 'kofiShortcode' . wp_rand( 1, 1000 );
			}

			$html_variable_name .= 'Html';

			wp_enqueue_script( 'ko-fi-button-widget' );
			wp_enqueue_script( 'ko-fi-button' );

			return sprintf(
				'<div class="ko-fi-button" data-text="%1$s" data-color="%2$s" data-code="%3$s" id="%4$s" style="%5$s"></div>',
				esc_attr( wp_strip_all_tags( $settings['coffee_text'] ) ),
				esc_attr( $settings['coffee_color'] ),
				esc_attr( $settings['coffee_code'] ),
				esc_attr( $html_variable_name ),
				esc_attr( $btn_container_style )
			);
		}
	}

	/**
	 * Clean up to run when uninstalling the plugin
	 * Was previously running on deactivation, leading to unnecessarily needing to input settings again when deactivating for testing
	 */
	public static function uninstall() {
		delete_option( 'ko_fi_options' );
	}

	/**
	 * Get the embed code for the donation panel
	 *
	 * @param array  $atts Optional (usually shortcode) attributes.
	 * @param string $widget_id Unique widget ID.
	 * @return string
	 */
	public static function get_panel_embed_code( $atts, $widget_id = '' ) {
		if ( isset( $atts['code'] ) && ! empty( $atts['code'] ) ) {
			$code = $atts['code'];
		} else {
			$code = self::get_plugin_option( 'coffee_code' );
		}
		if ( ! empty( $code ) ) {
			$return = '<iframe id="kofiframe" src="https://ko-fi.com/' . esc_attr( $code ) . '/?hidefeed=true&widget=true&embed=true&preview=true" style="border:none;width:100%;padding:4px;background:#f9f9f9;" height="712" title="%1$s"></iframe>';
		}
		return $return;
	}

	/**
	 * Get a username and sanitise it
	 *
	 * @param string $username Username string to sanitise.
	 * @return string
	 */
	public static function sanitise_username( $username ) {
		// Strip URL down to just a username.
		$username = str_replace( 'http://ko-fi.com/', '', $username );
		$username = str_replace( 'https://ko-fi.com/', '', $username );
		$username = str_replace( 'ko-fi.com/', '', $username );
		$username = rtrim( $username, '/' );
		return $username;
	}

	/**
	 * Determine whether to display floating button on the page
	 */
	public static function maybe_display_floating_button() {
		$value = false;
		// Get default from global options.
		$settings = self::get_plugin_option( 'coffee_floating_button_display' );
		if ( ! empty( $settings ) ) {
			if ( 'all' === $settings ) {
				$value = true;
			} elseif ( 'none' === $settings ) {
				$value = false;
			}
		} else {
			$value = false;
		}
		if ( is_singular() ) {
			// Overrides on individual pages.
			$post_meta = get_post_meta( get_the_ID(), 'kofi_display_floating_button', true );
			if ( ! empty( $post_meta ) ) {
				if ( 'yes' === $post_meta ) {
					$value = true;
				} elseif ( 'no' === $post_meta ) {
					$value = false;
				}
			}
		}
		if ( apply_filters( 'kofi_display_floating_button', $value ) ) {
			self::render_floating_button();
		}
	}

	/**
	 * Display the floating button
	 */
	public static function render_floating_button() {
		$code  = self::get_plugin_option( 'coffee_code' );
		$text  = self::get_plugin_option( 'coffee_floating_button_text' );
		$color = ! empty( self::get_plugin_option( 'coffee_floating_button_color' ) ) ? self::get_plugin_option( 'coffee_floating_button_color' ) : self::get_plugin_option( 'coffee_color' );
		wp_enqueue_script( 'ko-fi-floating-button' );
		wp_add_inline_script(
			'ko-fi-floating-button',
			sprintf(
				'kofiWidgetOverlay.draw( "%1$s", {
					"type": "floating-chat",
					"floating-chat.donateButton.text": "%2$s",
					"floating-chat.donateButton.background-color": "%3$s",
					"floating-chat.donateButton.text-color": "%4$s"
				});',
				esc_attr( $code ),
				esc_attr( $text ),
				esc_attr( $color ),
				esc_attr( self::get_contrast_yiq( $color ) )
			)
		);
	}

	/**
	 * Determine the color text should be based on the background colour
	 *
	 * @link https://24ways.org/2010/calculating-color-contrast/
	 * @param string $hex Colour hex value.
	 * @return string Black or white
	 */
	public static function get_contrast_yiq( $hex ) {
		$r   = hexdec( substr( $hex, 0, 2 ) );
		$g   = hexdec( substr( $hex, 2, 2 ) );
		$b   = hexdec( substr( $hex, 4, 2 ) );
		$yiq = ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000;
		return ( $yiq >= 128 ) ? '#323842' : '#fff';
	}

	/**
	 * Create a meta box on each public post type for Ko-fi related settings
	 */
	public static function register_posts_meta_box() {
		$public_post_types = get_post_types(
			array(
				'public' => true,
			),
			'names'
		);
		if ( ! empty( $public_post_types ) ) {
			foreach ( $public_post_types as $public_post_type ) {
				add_meta_box( 'kofi_posts', __( 'Ko-fi', 'ko-fi-button' ), array( __CLASS__, 'posts_meta_box_callback' ), $public_post_type, 'side' );
			}
		}
	}

	/**
	 * Callback function to render posts meta box
	 *
	 * @param WP_Post $post Post object.
	 */
	public static function posts_meta_box_callback( $post ) {
		$default = self::get_plugin_option( 'coffee_floating_button_display' );
		$value   = get_post_meta( get_the_ID( $post ), 'kofi_display_floating_button', true );
		wp_nonce_field( 'kofi_meta_box_save', 'kofi_meta_box_nonce' );
		?>
		<label>
			<p><strong><?php esc_html_e( 'Display floating button on this page', 'ko-fi-button' ); ?></strong></p>
			<select name="kofi_display_floating_button">
				<option value="">
					<?php
					printf(
						/* translators: 1. The default option for displaying the floating button (Show|Hide). */
						esc_html__( 'Default (%1$s)', 'ko-fi-button' ),
						'all' === $default ? esc_html__( 'Show', 'ko-fi-button' ) : esc_html__( 'Hide', 'ko-fi-button' )
					);
					?>
				</option>
				<option value="yes" <?php selected( 'yes', $value ); ?>>
					<?php esc_html_e( 'Always show on this page', 'ko-fi-button' ); ?>
				</option>
				<option value="no" <?php selected( 'no', $value ); ?>>
					<?php esc_html_e( 'Never show on this page', 'ko-fi-button' ); ?>
				</option>
			</select>
		</label>
		<?php
	}

	/**
	 * Save post meta from Ko-fi meta box
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_POST $post Post object.
	 */
	public static function save_post_meta( $post_id, $post ) {
		if ( isset( $_POST['kofi_meta_box_nonce'] ) && ! empty( $_POST['kofi_meta_box_nonce'] ) ) {
			$nonce = sanitize_text_field( wp_unslash( $_POST['kofi_meta_box_nonce'] ) );
			if ( wp_verify_nonce( $nonce, 'kofi_meta_box_save' ) ) {
				if ( current_user_can( 'edit_post', $post_id ) ) {
					if ( isset( $_POST['kofi_display_floating_button'] ) ) {
						$kofi_display_floating_button = sanitize_text_field( wp_unslash( $_POST['kofi_display_floating_button'] ) );
						update_post_meta( $post_id, 'kofi_display_floating_button', $kofi_display_floating_button );
					}
				}
			}
		}
	}

	/**
	 * Prevent the floating button from displaying over the top of legacy widgets when enabled.
	 */
	public static function prevent_floating_button_displaying_on_widget_previews() {
		add_filter( 'kofi_display_floating_button', '__return_false' );
	}

	/**
	 * Get plugin option if set, otherwise get the default
	 *
	 * @param string $option Option array key.
	 * @return mixed
	 */
	public static function get_plugin_option( $option ) {
		return isset( self::$options[ $option ] ) && ! empty( self::$options[ $option ] ) ? self::$options[ $option ] : Default_ko_fi_options::get()['defaults'][ $option ];
	}

}
