<?php
/**
 * Default settings page options
 *
 * @package kofi-wordpress-button
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class that holds the options page settings
 */
class Default_Ko_Fi_Options {

	/**
	 * Get the options for the settings page, including default values
	 */
	public static function get() {
		return array(
			'page_title'       => __( 'Ko-fi Settings', 'ko-fi-button' ),
			'page_description' => sprintf(
				/* translators: 1. Anchor tag linking to Ko-fi website. 2. Closing anchor tag. 3. Anchor tag linking to installation guide */
				__(
					"Link your Ko-fi page or create one at %1\$swww.ko-fi.com%2\$s. Add a Ko-fi donation button to any Widget area or use the [kofi] shortcode to add your button to any Page or Post.\n\rNot sure where to start? %3\$sTake a look at our guide &#x2197;%2\$s",
					'Ko_fi'
				),
				'<a href="https://www.ko-fi.com" target="_blank" rel="noopener">',
				'</a>',
				'<a href="https://help.ko-fi.com/hc/en-us/articles/115004002614-Adding-a-Ko-fi-Button-to-your-WordPress-site-or-blog" target="_blank" rel="noopener">'
			),
			'menu_title'       => __( 'Ko-fi Settings', 'ko-fi-button' ),
			'capability'       => 'manage_options',
			'menu_slug'        => 'ko_fi_options',
			'option_name'      => 'ko_fi_options',
			'page_name'        => 'ko_fi_options',
			'defaults'         => array(
				'coffee_title'                   => __( 'Support This Site', 'ko-fi-button' ),
				'coffee_text'                    => __( 'Buy me a coffee!', 'ko-fi-button' ),
				'coffee_color'                   => '#ff5f5f',
				'coffee_description'             => __( 'If you like what I do please support me on Ko-fi', 'ko-fi-button' ),
				'coffee_code'                    => '',
				'coffee_hyperlink'               => false,
				'coffee_button_alignment'        => 'left',
				'coffee_html_title'              => '',
				'coffee_floating_button_display' => 'none',
				'coffee_floating_button_text'    => __( 'Support Me', 'ko-fi-button' ),
				'coffee_floating_button_color'   => '',
			),
			'sections'         => array(
				array(
					'slug'                => 'coffee_button_settings',
					'slug_prefix'         => 'coffee',
					'section_description' => __( 'These are settings for the [kofi] shortcode and default settings for widgets', 'ko-fi-button' ),
					'title'               => __( 'Button Settings', 'ko-fi-button' ),
					'fields'              => array(
						array(
							'slug'        => 'code',
							'title'       => __( 'Page Name or ID', 'ko-fi-button' ),
							'type'        => 'text',
							'description' => __( 'Your Ko-fi Page Name (the bit after Ko-fi.com in the URL bar) e.g. ko-fi.com/supportkofi just enter supportkofi', 'ko-fi-button' ),
							'placeholder' => 'supportkofi',
						),
						array(
							'slug'        => 'text',
							'title'       => __( 'Button Text', 'ko-fi-button' ),
							'type'        => 'text',
							'description' => __( 'This text will appear on the button (so don\'t make it too long!).', 'ko-fi-button' ),
						),
						array(
							'slug'        => 'color',
							'title'       => __( 'Button Color', 'ko-fi-button' ),
							'type'        => 'color',
							'description' => __( 'Default button color. This is a hex value.', 'ko-fi-button' ),

						),
					),
				),
				array(
					'slug'                => 'coffee_default_widget_settings',
					'slug_prefix'         => 'coffee',
					'section_description' => __( 'You can override these in your widget settings', 'ko-fi-button' ),
					'title'               => __( 'Widget Default Settings', 'ko-fi-button' ),
					'fields'              => array(
						array(
							'slug'        => 'title',
							'title'       => __( 'Title', 'ko-fi-button' ),
							'type'        => 'text',
							'description' => __( 'Default title for your Ko-fi widgets. The title will only display above the widgets, not the shortcode link.', 'ko-fi-button' ),
							'label'       => __( 'Title', 'ko-fi-button' ),
						),
						array(
							'slug'        => 'description',
							'title'       => __( 'Description', 'ko-fi-button' ),
							'type'        => 'textarea',
							'description' => __( 'Description will appear above the button.', 'ko-fi-button' ),
						),
						array(
							'slug'        => 'hyperlink',
							'title'       => __( 'Text link only', 'ko-fi-button' ),
							'type'        => 'checkbox',
							'label'       => '',
							'description' => __( 'Check this box to display your Ko-fi link as a simple text link (removes button background and doesn\'t use JavaScript)', 'ko-fi-button' ),
						),
						array(
							'slug'        => 'button_alignment',
							'title'       => __( 'Alignment', 'ko-fi-button' ),
							'type'        => 'select',
							'label'       => __( 'Alignment', 'ko-fi-button' ),
							'description' => __( 'Select left, right or center button alignment.', 'ko-fi-button' ),
							'options'     => array(
								'list' => array(
									'left'   => __( 'Left', 'ko-fi-button' ),
									'centre' => __( 'Centre', 'ko-fi-button' ),
									'right'  => __( 'Right', 'ko-fi-button' ),
								),
							),
						),
						array(
							'slug'        => 'html_title',
							'title'       => __( 'Title Tag', 'ko-fi-button' ),
							'type'        => 'text',
							'description' => __( 'Default hover text for your Ko-fi buttons.', 'ko-fi-button' ),
							'label'       => __( 'Title Tag', 'ko-fi-button' ),
						),
					),
				),
				array(
					'slug'                => 'coffee_default_floating_button_settings',
					'slug_prefix'         => 'coffee',
					'section_description' => __( 'The floating widget displays a button fixed to the bottom left of the window. By default it will inherit the button\'s default code and color', 'ko-fi-button' ),
					'title'               => __( 'Floating Button Settings', 'ko-fi-button' ),
					'fields'              => array(
						array(
							'slug'        => 'floating_button_display',
							'title'       => __( 'Default Display', 'ko-fi-button' ),
							'type'        => 'select',
							'description' => __( 'Choose the default display setting. This can be overridden on individual pages.', 'ko-fi-button' ),
							'options'     => array(
								'list' => array(
									'none' => __( 'Hide on all pages', 'ko-fi-button' ),
									'all'  => __( 'Show on all pages', 'ko-fi-button' ),
								),
							),
						),
						array(
							'slug'        => 'floating_button_text',
							'title'       => __( 'Button Text', 'ko-fi-button' ),
							'type'        => 'text',
							'description' => __( 'This text will appear on the floating button (so don\'t make it too long!).', 'ko-fi-button' ),
						),
						array(
							'slug'        => 'floating_button_color',
							'title'       => __( 'Button Color', 'ko-fi-button' ),
							'type'        => 'color',
							'description' => __( 'Floating button color. This is a hex value.', 'ko-fi-button' ),
						),
					),
				),
			),
		);
	}
}
