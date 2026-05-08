<?php
if ( isset( $attributes['code'] ) && ! empty( $attributes['code'] ) ) {
	$code = $attributes['code'];
} else {
	$code = Ko_Fi::get_plugin_option( 'coffee_code' );
}
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<iframe id="kofiframe" src="https://ko-fi.com/<?php echo esc_attr( $code ); ?>/?hidefeed=true&widget=true&embed=true&preview=true" style="border:none;width:100%;padding:4px;background:#f9f9f9;display:block;" height="712" title="%1$s"></iframe>
</div>
