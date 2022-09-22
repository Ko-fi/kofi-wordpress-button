jQuery( document ).ready( function() {
	/**
	 * @link https://wordpress.stackexchange.com/a/325733/65582
	 */

	function initColorPicker( $widget ) {
		$widget.find( '.jscolor' ).wpColorPicker({
			/**
			 * Throttle required to both trigger change event _and_ allow colour to actually change, for some reason.
			 *
			 * @todo Remove throttle at some point in the future
			 */
			change: _.throttle( function() {
				jQuery( this ).trigger( 'change' );
			}, 1000 )
		});
	}

	function onFormUpdate( event, $widget ) {
		initColorPicker( $widget );
	}

	jQuery( document ).on( 'widget-added widget-updated', onFormUpdate );

	/* Classic widgets */
	jQuery( document ).ready( function() {
		jQuery( '.widget-inside:has( .jscolor )' ).each( function () {
			initColorPicker( jQuery( this ) );
		});

		jQuery( '.ko-fi-settings .jscolor' ).wpColorPicker();
	});
});
