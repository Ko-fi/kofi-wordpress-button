<?php

class Default_ko_fi_options {

	public static function get(){
		return array(
			'page_title'        => __( 'Ko-fi Settings', 'Ko_fi' ),
			'page_description'  => __( 'Link your Ko-fi page or create one at <a href="https://www.ko-fi.com">www.ko-fi.com</a>. Add a Ko-fi donation button to any Widget area or use the [kofi] shortcode to add your button to any Page or Post.', 'Ko_fi' ),
			'menu_title'        => __( 'Ko-fi Settings', 'Ko_fi' ),
			'capability'        => 'manage_options',
			'menu_slug'         => 'ko_fi_options',
			'option_name'       => 'ko_fi_options',
			'page_name'         => 'ko_fi_options',
			'defaults'          => array(
				'coffee_title'      		=> __( 'Support This Site', 'Ko_fi' ),
				'coffee_text'       		=> __( 'Buy me a coffee!', 'Ko_fi' ),
				'coffee_color'      		=> __('ff5f5f', 'Ko_fi' ),
                'coffee_description'		=> __( 'If you like what I do please support me on Ko-fi', 'Ko_fi' ),
				'coffee_code'       		=> '',
				'coffee_hyperlink'  		=> false,
				'coffee_button_alignment' 	=> 'left'
			),
			'sections' => [
				[
					'slug'  => 'coffee_button_settings',
					'slug_prefix' => 'coffee',
					'section_description' => __( 'These are settings for the [kofi] shortcode and default settings for widgets', 'Ko_fi') ,
					'title' => __( 'Button Settings', 'Ko_fi' ),
					'fields'=> [
						[
							'slug'        => 'code',
							'title'       => __( 'Page Name or ID', 'Ko_fi' ),
							'type'        => 'text',
							'description' => __( 'Your Ko-fi Page Name (the bit after Ko-fi.com in the URL bar) e.g. ko-fi.com/supportkofi just enter supportkofi', 'Ko_fi' ),
							'placeholder' => __( 'supportkofi', 'Ko_fi' ),
						],						
						[
							'slug'        => 'text',
							'title'       => __( 'Button Text', 'Ko_fi' ),
							'type'        => 'text',
                            'description' => __( 'This text will appear on the button (so don\'t make it too long!).' , 'Ko_fi' )
						],
						[
							'slug'        => 'color',
							'title'       => __( 'Button Color', 'Ko_fi' ),
							'type'        => 'color',
							'description' => __( 'Default button color. This is a hex value.', 'Ko_fi' ),

						]
					]
				],
				[
					'slug'  => 'coffee_default_widget_settings',
					'slug_prefix' => 'coffee',
					'section_description' => __( 'You can override these in your widget settings', 'Ko_fi' ),
					'title' => __( 'Widget Default Settings', 'Ko_fi' ),
					'fields'=> [							
						[
							'slug'        => 'title',
							'title'       => __( 'Title', 'Ko_fi' ),
							'type'        => 'text',
							'description' => __( 'Default title for your ko-fi widgets. The title will only display above the widgets, not the shortcode link.', 'Ko_fi' ),
							'label'       => __( 'Title', 'Ko_fi' )
						],
						[
							'slug'        => 'description',
							'title'       => __( 'Description', 'Ko_fi' ),
							'type'        => 'textarea',
							'description' => __( 'Description will appear above the button.', 'Ko_fi' ),

						],						
						[
							'slug'        => 'hyperlink',
							'title'       => __( 'Text link only', 'Ko_fi' ),
							'type'        => 'checkbox',
							'label'       => '',
							'description' => __( 'Check this box to display your Ko-fi link as a simple text link (removes button background and doesn\'t use JavaScript)', 'Ko_fi' ),
						],
						[
							'slug'        => 'button_alignment',
							'title'       => __( 'Alignment', 'Ko_fi' ),
							'type'        => 'select',
							'label'       => 'Alignment',
							'description' => __( 'Select left, right or center button alignment.', 'Ko_fi' ),
							'options'	  => [ 'list' => [ 'left' => 'Left', 'centre' => 'Centre', 'right' => 'Right' ] ],
						],
					]
				]
			]
		);
	}

}