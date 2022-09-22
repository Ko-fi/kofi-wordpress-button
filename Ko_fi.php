<?php
/**
 * Plugin Name: Ko-fi Button
 * Plugin URI:
 * Description: A Ko-fi donate button for your website!
 * Version: 1.1.0
 * Author: Ko-fi Team
 * Author URI: https://www.ko-fi.com
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if (!function_exists('write_log')) {
	function write_log ( $log )  {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}

class Ko_Fi
{

	public static $options = [];

	public static function init()
	{
		add_action('widgets_init', [__CLASS__, 'widget']);
		add_action( 'init', array( __CLASS__, 'register_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_scripts' ), 9 );
		add_shortcode('kofi', [__CLASS__, 'kofi_shortcode']);

		require_once 'Default_ko_fi_options.php';
		require_once 'Ko_fi_Options.php';
		self::$options = (new Ko_fi_Options())->get();
		add_filter('plugin_action_links', [__CLASS__,'add_action_links'],10,5);
		register_deactivation_hook( __FILE__, [__CLASS__,'deactivate'] );
	}

	public static function add_action_links($actions, $plugin_file)
	{
		static $plugin;

		if (!isset($plugin))
			$plugin = plugin_basename(__FILE__);
		if ($plugin == $plugin_file) {

			$settings_url = sprintf('<a href="%s">Settings</a>', menu_page_url(Default_ko_fi_options::get()['menu_slug'], false));
			$plugin_links = [
				'settings' => $settings_url
			];

			$actions = array_merge($plugin_links, $actions);
		}

		return $actions;
	}

	/**
	 * Register any custom scripts and styles we'll need
	 */
	public static function register_scripts() {
		$dir_url     = plugin_dir_url( __FILE__ );
		$plugin_data = get_plugin_data( __FILE__ );
		wp_register_script( 'extra', $dir_url . 'extra.js', array( 'jquery' ), $plugin_data['Version'], true );
		wp_register_script( 'ko-fi-button-widget', 'https://storage.ko-fi.com/cdn/widget/Widget_2.js', array( 'jquery' ), $plugin_data['Version'], true );
		wp_register_script( 'ko-fi-button', trailingslashit( $dir_url ) . 'js/widget.js', array( 'jquery', 'ko-fi-button-widget' ), $plugin_data['Version'], true );
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
		require_once 'ko-fi-button-widget.php';
		register_widget( 'ko_fi_widget' );
		require_once 'class-ko-fi-panel-widget.php';
		register_widget( 'ko_fi_panel_widget' );

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
				'text'  => self::$options['coffee_text'],
				'color' => self::$options['coffee_color'],
				'type'  => 'button',
				'code'  => self::$options['coffee_code'],
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

	public static function get_jscolor( $args ) {
		echo sprintf(
			'<input class="jscolor"  id="%1$s" name="%2$s" value="%3$s" />',
			esc_attr( $args['option_id'] ),
			esc_attr( empty( $args['name'] ) ? $args['option_id'] : $args['name'] ),
			esc_attr( $args['value'] )
		);
	}

	public static function get_button_embed_code($atts, $widget_id = '')
	{
		$settings = wp_parse_args($atts, self::$options);
		foreach ( $atts as $key => $value ) {
			switch ($key) {
				case 'title'  :
					$key = 'coffee_title';
					break;
				case 'text'   :
					$key = 'coffee_text';
					break;
				case 'hyperlink' :
					$key = 'coffee_hyperlink';
					break;
				case 'color' :
					$key = 'coffee_color';
					$value = '#' . ltrim( $value, '#' );
					break;
				case 'code':
					$key = 'coffee_code';
					if ( empty( $value ) ) {
						$value = self::sanitise_username( self::$options['coffee_code'] );
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
				'<div style="%1$s" class="ko-fi-button"><div class="btn-container"><a href="http://www.ko-fi.com/%2$s">%3$s</a></div>',
				esc_attr( $btn_container_style ),
				esc_attr( $settings['coffee_code'] ),
				esc_html( $settings['coffee_text'] )
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
				self::sanitise_coffee_text( $settings['coffee_text'] ),
				esc_attr( $settings['coffee_color'] ),
				esc_attr( $settings['coffee_code'] ),
				esc_attr( $html_variable_name ),
				esc_attr( $btn_container_style )
			);
		}
	}

	public static function deactivate() {
		delete_option( 'ko_fi_options' );
	}

	public static function sanitise_coffee_text( $text ) {
		return str_replace( '"', '', $text );
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
			$code = self::$options['coffee_code'];
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
		$username = rtrim( $username, '/' );
		return $username;
	}

}

add_action( 'plugins_loaded', array( 'Ko_Fi', 'init' ) );
