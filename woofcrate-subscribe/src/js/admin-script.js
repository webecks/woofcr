'use strict';

( function ( $ ) {
	const imgTag = '<img src="" class="attachment-thumbnail" style="display:none;">',
		mediaUpload = elm => {
			const origSendAttachment = wp.media.editor.send.attachment;
			let customMedia = true;

			$( 'body' ).on( 'click', elm, function () {
				const $this = $( this ),
					thisID = $this.attr( 'id' ),
					$imageID = $( `#${$this.data( 'target' )}` ),
					$imageWrapper = $imageID.next();

				wp.media.editor.send.attachment = ( props, attachment ) => {
					if ( customMedia ) {
						$imageID.val( attachment.id );
						$imageWrapper.html( imgTag );
						$imageWrapper.find( '.attachment-thumbnail' ).attr( 'src', attachment.sizes.thumbnail.url ).css( 'display', 'block' );
					} else {
						return origSendAttachment.apply( `#${thisID}`, [ props, attachment ] );
					}
				};

				wp.media.editor.open( thisID );
				return false;
			});
		};

	mediaUpload( 'button[name="add_image"]' );

	$( 'body' ).on( 'click', 'button[name="remove_image"]', function () {
		const $imageID = $( `#${$( this ).data( 'target' )}` );

		$imageID.val( '0' );
		$imageID.next().html( imgTag );
	});

	$( document ).ajaxComplete( ( e, xhr, settings ) => {
		const queryStringArr = settings.data.split( '&' );

		if ( $.inArray( 'action=add-tag', queryStringArr ) !== -1 ) {
			if ( $( xhr.responseXML ).find( 'term_id' ).text() !== '' ) {
				$( '.image_wrapper' ).html( '' );
			}
		}
	});
})( jQuery );
