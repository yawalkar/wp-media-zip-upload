(function($)
{
	"use strict";
	// Uploading files
	var file_frame, attachment;

	// Add page slug to media uploader settings
	_wpPluploadSettings['defaults']['multipart_params']['admin_page']= 'ny-zip-upload';

	jQuery('.wp_uploader_button').on('click', function( event ){

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.open();
			return;
		}

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: "My ZIP Uploader",
			button: {
				text: "Upload ZIP File",
			},
			library: {
				type: 'application/zip'
			},
		  multiple: false  // Set to true to allow multiple files to be selected
		});

		// When the file is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one file from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();
			jQuery(".wp_upload_field").val(attachment.url);
		});

		// Finally, open the modal
		file_frame.open();
	});
})(jQuery);