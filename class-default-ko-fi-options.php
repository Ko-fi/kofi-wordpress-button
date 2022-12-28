<?php
/**
 * Default settings page options
 *
 * @package kofi-wordpress-button
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Default_Ko_Fi_Options {

	public static function get() {
		return array(
			'page_title'       => __( 'Ko-fi Settings', 'Ko_fi' ),
			'page_description' => __( 'Link your Ko-fi page or create one at <a href="https://www.ko-fi.com">www.ko-fi.com</a>. Add a Ko-fi donation button to any Widget area or use the array(kofi) shortcode to add your button to any Page or Post.', 'Ko_fi' ),
			'menu_title'       => __( 'Ko-fi Settings', 'Ko_fi' ),
			'capability'       => 'manage_options',
			'menu_slug'        => 'ko_fi_options',
			'option_name'      => 'ko_fi_options',
			'page_name'        => 'ko_fi_options',
			'defaults'         => array(
				'coffee_title'                   => __( 'Support This Site', 'Ko_fi' ),
				'coffee_text'                    => __( 'Buy me a coffee!', 'Ko_fi' ),
				'coffee_color'                   => __( '#ff5f5f', 'Ko_fi' ),
				'coffee_description'             => __( 'If you like what I do please support me on Ko-fi', 'Ko_fi' ),
				'coffee_code'                    => '',
				'coffee_hyperlink'               => false,
				'coffee_button_alignment'        => 'left',
				'coffee_floating_button_enabled' => false,
				'coffee_floating_button_text'    => 'Support Me',
			),
			'sections'         => array(
				array(
					'slug'                => 'coffee_button_settings',
					'slug_prefix'         => 'coffee',
					'section_description' => __( 'These are settings for the array(kofi) shortcode and default settings for widgets', 'Ko_fi' ),
					'title'               => __( 'Button Settings', 'Ko_fi' ),
					'fields'              => array(
						array(
							'slug'        => 'code',
							'title'       => __( 'Page Name or ID', 'Ko_fi' ),
							'type'        => 'text',
							'description' => __( 'Your Ko-fi Page Name (the bit after Ko-fi.com in the URL bar) e.g. ko-fi.com/supportkofi just enter supportkofi', 'Ko_fi' ),
							'placeholder' => __( 'supportkofi', 'Ko_fi' ),
						),
						array(
							'slug'        => 'text',
							'title'       => __( 'Button Text', 'Ko_fi' ),
							'type'        => 'text',
							'description' => __( 'This text will appear on the button (so don\'t make it too long!).', 'Ko_fi' ),
						),
						array(
							'slug'        => 'color',
							'title'       => __( 'Button Color', 'Ko_fi' ),
							'type'        => 'color',
							'description' => __( 'Default button color. This is a hex value.', 'Ko_fi' ),

						),
					),
				),
				array(
					'slug'                => 'coffee_default_widget_settings',
					'slug_prefix'         => 'coffee',
					'section_description' => __( 'You can override these in your widget settings', 'Ko_fi' ),
					'title'               => __( 'Widget Default Settings', 'Ko_fi' ),
					'fields'              => array(
						array(
							'slug'        => 'title',
							'title'       => __( 'Title', 'Ko_fi' ),
							'type'        => 'text',
							'description' => __( 'Default title for your ko-fi widgets. The title will only display above the widgets, not the shortcode link.', 'Ko_fi' ),
							'label'       => __( 'Title', 'Ko_fi' ),
						),
						array(
							'slug'        => 'description',
							'title'       => __( 'Description', 'Ko_fi' ),
							'type'        => 'textarea',
							'description' => __( 'Description will appear above the button.', 'Ko_fi' ),

						),
						array(
							'slug'        => 'hyperlink',
							'title'       => __( 'Text link only', 'Ko_fi' ),
							'type'        => 'checkbox',
							'label'       => '',
							'description' => __( 'Check this box to display your Ko-fi link as a simple text link (removes button background and doesn\'t use JavaScript)', 'Ko_fi' ),
						),
						array(
							'slug'        => 'button_alignment',
							'title'       => __( 'Alignment', 'Ko_fi' ),
							'type'        => 'select',
							'label'       => 'Alignment',
							'description' => __( 'Select left, right or center button alignment.', 'Ko_fi' ),
							'options'     => array(
								'list' => array(
									'left'   => 'Left',
									'centre' => 'Centre',
									'right'  => 'Right',
								),
							),
						),
					),
				),
				array(
					'slug'                => 'coffee_default_floating_button_settings',
					'slug_prefix'         => 'coffee',
					'section_description' => __( 'The floating widget displays a button fixed to the bottom left of the window. By default it will inherit the button\'s default code and color', 'Ko_fi' ),
					'title'               => __( 'Floating Button Settings', 'Ko_fi' ),
					'fields'              => array(
						array(
							'slug'        => 'floating_button_enabled',
							'title'       => __( 'Enabled', 'Ko_fi' ),
							'type'        => 'checkbox',
							'description' => __( 'Display the floating button on all pages.', 'Ko_fi' ),
						),
						array(
							'slug'        => 'floating_button_code',
							'title'       => __( 'Page Name or ID', 'Ko_fi' ),
							'type'        => 'text',
							'description' => __( 'Your Ko-fi Page Name (the bit after Ko-fi.com in the URL bar) e.g. ko-fi.com/supportkofi just enter supportkofi', 'Ko_fi' ),
							'placeholder' => __( 'supportkofi', 'Ko_fi' ),
						),
						array(
							'slug'        => 'floating_button_text',
							'title'       => __( 'Button Text', 'Ko_fi' ),
							'type'        => 'text',
							'description' => __( 'This text will appear on the floating button (so don\'t make it too long!).', 'Ko_fi' ),
						),
						array(
							'slug'        => 'floating_button_color',
							'title'       => __( 'Button Color', 'Ko_fi' ),
							'type'        => 'color',
							'description' => __( 'Floating button color. This is a hex value.', 'Ko_fi' ),

						),
					),
				),
			),
		);
	}

}
