jQuery( function( $ ) {
  $( document ).on( 'click', 'body:not(.elementor-editor-active) .make-clickable-elementor-column', function( e ) {
    var wrapper = $( this ),
        url     = wrapper.data( 'clickable-column' );

    if ( url ) {
      if ( $( e.target ).filter( 'a, a *, .no-link, .no-link *' ).length ) {
        return true;
      }

      // handle elementor actions
      if ( url.match( "^#elementor-action" ) ) {

        var hash = url;
        var hash = decodeURIComponent( hash );

        // if is Popup
        if ( hash.includes( "elementor-action:action=popup:open" ) || hash.includes( "elementor-action:action=lightbox" ) ) {

          if ( 0 === wrapper.find( '#clickable-elementor-columns-open-dynamic' ).length ) {
            wrapper.append( '<a id="clickable-elementor-columns-open-dynamic" style="display: none !important;" href="' + url + '">Open dynamic content</a>' );
          }

          wrapper.find( '#clickable-elementor-columns-open-dynamic' ).click();

          return true;
        }

        return true;
      }

      // smooth scroll
      if ( url.match( "^#" ) ) {
        var hash = url;

        $( 'html, body' ).animate( {
          scrollTop: $( hash ).offset().top
        }, 800, function() {
          window.location.hash = hash;
        });

        return true;
      }

      window.open( url, wrapper.data( 'column-clickable-blank' ) );
      return false;
    }
  });
});
