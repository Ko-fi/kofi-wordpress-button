<?php
$args = array();
if ( ! empty( $attributes ) ) {
	foreach ( $attributes as $key => $val ) {
		if ( ! empty( $val ) ) {
			if ( $key === 'title' ) {
				$new_key = 'html_title';
			} elseif( $key === 'button_alignment' ) {
				if ( $val === 'center' ) {
					$new_val = 'centre';
				}
			}
			$new_key = isset( $new_key ) ? $new_key : $key;
			$new_val = isset( $new_val ) ? $new_val : $val;
			$args[ $new_key ] = $new_val;
			unset( $new_key );
			unset( $new_val );
		}
	}
}
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<?php echo Ko_Fi::get_button_embed_code( $args ); ?>
</div>
