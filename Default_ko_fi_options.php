<?php

class Default_ko_fi_options {

	public static function get(){
		return array(
			'page_title'        => __( 'ko-fi Settings', 'Ko_fi' ),
			'page_description'  => false,
			'menu_title'        => __( 'ko-fi Settings', 'Ko_fi' ),
			'capability'        => 'manage_options',
			'menu_slug'         => 'ko_fi_options',
			'option_name'       => 'ko_fi_options',
			'page_name'         => 'ko_fi_options',
			'defaults'          => array(
				'coffee_title'      => __( 'My Ko-fi button', 'Ko_fi' ),
				'coffee_text'       => __( 'Buy me a coffee!', 'Ko_fi' ),
				'coffee_color'      => __('46b798', 'Ko_fi' ),
                'coffee_description'=> __( 'Buy me a coffee!', 'Ko_fi' ),
				'coffee_code'       => 'http://ko-fi.com/',
                'coffee_hyperlink'  => false
			),
			'sections'           => array(
				array(
					'slug'  => 'coffee',
					'title' => __( 'Main Settings', 'Ko_fi' ),
					'fields'=> array(
						array(
							'slug'        => 'title',
							'title'       => __( 'Default Title', 'Ko_fi' ),
							'type'        => 'text',
                            'description' => __( 'Default title for your ko-fi widgets. The title will only display above the widgets, not the shortcode link.', 'Ko_fi' ),
                            'label'       => __( 'Test label', 'Ko_fi' )
						),
						array(
							'slug'        => 'text',
							'title'       => __( 'Default Text', 'Ko_fi' ),
							'type'        => 'text',
                            'description' => __( 'This text will appear on the button(so don\'t make it too long!).' , 'Ko_fi' )
						),
						array(
							'slug'        => 'color',
							'title'       => __( 'Default Color', 'Ko_fi' ),
							'type'        => 'color',
							'description' => __( 'Default button color. This is a hex value.', 'Ko_fi' ),

						),
                        array(
                            'slug'        => 'description',
                            'title'       => __( 'Default Description', 'Ko_fi' ),
                            'type'        => 'textarea',
                            'description' => __( 'Description will appear above the button.', 'Ko_fi' ),

                        ),
						array(
							'slug'        => 'code',
							'title'       => __( 'Default Code', 'Ko_fi' ),
							'type'        => 'text',
							'description' => __( 'Your ko-fi code or link.', 'Ko_fi' ),
						),
                        array(
                            'slug'        => 'hyperlink',
                            'title'       => __( 'Hyperlink', 'Ko_fi' ),
                            'type'        => 'checkbox',
                            'label'       => 'Hyperlink',
                            'description' => __( 'Check this box if you want to display your button as a hyperlink by default.', 'Ko_fi' ),
                        )
					)
				)
			)
		);
	}

}