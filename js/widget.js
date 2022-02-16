jQuery( document ).ready( function() {
	jQuery( '.ko-fi-button' ).each( function() {
		var $this = jQuery( this );
		kofiwidget2.init( $this.data( 'text' ), $this.data( 'color' ), $this.data( 'code' ) );
		$this.html( kofiwidget2.getHTML() );
	});
});
