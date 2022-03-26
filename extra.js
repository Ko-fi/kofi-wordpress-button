jQuery( document ).ready( function() {
	jQuery( '.kofi-color-picker' ).wpColorPicker();
});

jQuery( document ).ajaxComplete( function() {
	jQuery( '.kofi-color-picker' ).wpColorPicker();
});
