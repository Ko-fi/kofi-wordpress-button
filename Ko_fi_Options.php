<?php

class Ko_fi_Options {
	protected $options = [ ];
	protected $fallbacks = [ ];

	public function __construct() {
		$this->options = Default_ko_fi_options::get();

		$this->fallbacks = get_option( $this->options['option_name'] );

		if ( false === $this->fallbacks ) {
			$this->default_fallbacks();
		}

		add_action( 'admin_init', [ $this, 'set_options' ] );
		add_action( 'admin_menu', [ $this, 'menu' ] );

	}


	public function default_fallbacks() {
		update_option( $this->options['option_name'], $this->options['defaults'] );
		$this->fallbacks = $this->options['defaults'];
	}

	public function menu() {
		add_options_page(
			$this->options['page_title'],
			$this->options['menu_title'],
			$this->options['capability'],
			$this->options['menu_slug'],
			[
				$this,
				'get_page_html'
			]
		);
	}

	public function get_page_html() {
		?>
		<div class="wrap">
			<h1><?php echo esc_html( $this->options['menu_title'] ); ?></h1>
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

	public function set_options() {

		register_setting(
			$this->options['option_name'],
			$this->options['option_name']
		//todo: set up validate function;
		);

		foreach ( $this->options['sections'] as $section ) {

			add_settings_section( $section['slug'], $section['title'], '', $this->options['page_name'] );

			foreach ( $section['fields'] as $field ) {

				$id = sprintf(
					'%s[%s_%s]',
					$this->options['page_name'],
					$section['slug'],
					$field['slug'] );

				$selector = sprintf(
					'%s_%s_%s',
					$this->options['page_name'],
					$section['slug'],
					$field['slug'] );

				add_settings_field(
					$id,
					sprintf( '<label for="%s">%s</label>',
						esc_attr( $id ),
						esc_html( $field['title'] )
					),
					[ $this, 'get_field' ],
					$this->options['page_name'],
					$section['slug'],
					[
						'option_type' => $field['type'],
						'option_id'   => $id,
						'description' => empty( $field['description'] ) ? '' : $field['description'],
						'label'       => empty( $field['label'] ) ? '' : $field['label'],
						'options'     => isset( $field['options'] ) ? '' : false,
						'value'       => isset( $this->fallbacks["{$section['slug']}_{$field['slug']}"] ) ? $this->fallbacks["{$section['slug']}_{$field['slug']}"] : false,
						'selector'	  => $selector
					]
				);
			}
		}
	}

	public function get() {
		return get_option( $this->options['option_name'] );
	}

	public function get_field( $args ) {
		call_user_func( array( $this, $args['option_type'] ), $args );
		if ( ! empty( $args['description'] ) ) :
			?>
			<p class="description"><?php echo $args['description'] ?></p>
		<?php endif;
	}


	public function text( $args ) {
		printf(
			'<input class="regular-text" id="%1$s" name="%2$s" type="text" value="%3$s" />',
			esc_attr( $args['selector'] ),
			esc_attr( $args['option_id'] ),
			esc_attr( $args['value'] )
		);
	}

	public function color( $args ) {
		echo Ko_Fi::get_jscolor($args);
	}

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

	public function textarea( $args ) {
		printf(
			'<textarea class="all-options" id="%1$s" name="%2$s" rows="5">%3$s</textarea>',
			esc_attr( $args['selector'] ),
			esc_attr( $args['option_id'] ),
			esc_html( $args['value'] )
		);
	}


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