jQuery( document ).ready( function() {
	jQuery( '.ko-fi-button' ).each( function() {
		var $this = jQuery( this );
		var title = $this.data( 'title' );
		kofiwidget2.init( $this.data( 'text' ), $this.data( 'color' ), $this.data( 'code' ) );
		$html = kofiwidget2.getHTML();
		if ( title ) {
			console.log( $html );
			$html = $html.replace( 'title="Support me on ko-fi.com"', 'title="' + title + '"' );
		}
		$this.html( $html );
	});
});
