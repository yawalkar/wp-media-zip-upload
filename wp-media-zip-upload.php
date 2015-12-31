<?php
/*
Plugin Name: WP Media Zip Upload
Plugin URI: https://github.com/yawalkar/wp-media-zip-upload
Description: Restrict other extensions for your plugin admin upload functionality.
Author: Nitin Yawalkar
Author URI: https://www.nitinyawalkar.com
Version: 1.0
*/
if( !class_exists( "NY_WP_ZIP_UPLOAD" ) ){
	class NY_WP_ZIP_UPLOAD{
		function __construct(){
			add_action( 'admin_menu', array( $this, 'ny_plugin_setup_menu' ) );
		}

		function ny_plugin_setup_menu(){
			$page = add_menu_page(
				'Plugin Admin Page',
				'ZIP Upload',
				'administrator',
				'ny-zip-upload',
				array( $this, 'zip_upload_init' )
			);

			add_action('admin_print_scripts-'.$page, array( $this, 'admin_media_scripts' ) );
		}

		function admin_media_scripts(){
			wp_enqueue_media();
			wp_enqueue_script("ny-media-js", plugins_url( "media.js", __FILE__ ), array( 'jquery' ),'',true );
		}

		function zip_upload_init(){

			?>
			<div class="wrap about-wrap">
				<h1>WP Media Zip Upload</h1>
				<div class="about-text">This is just a test plugin to test the zip upload functionality by restricting all other file extensions.</div>
				<div class="wp-container">
					<input type="text" class="wp_upload_field" />
					<button class="button button-primary wp_uploader_button">Upload Zip</button>
				</div>
			</div>
			<?php
		}
	}

	new NY_WP_ZIP_UPLOAD;
}


// Function to handle and restrict upload to our custom extension only for our plugin admin page
if( !function_exists( "ny_import_upload_prefilter" ) ){
	add_filter( 'wp_handle_upload_prefilter', 'ny_import_upload_prefilter' );
	function ny_import_upload_prefilter( $file )
	{
		$page = isset( $_POST['admin_page'] ) ? $_POST['admin_page'] : '';

		if( isset( $page ) && $page == "ny-zip-upload" ) {

			$ext = pathinfo( $file['name'], PATHINFO_EXTENSION );

			if ( $ext !== "zip" ) {
				$file['error'] = "The uploaded ". $ext ." file is not supported. Please upload the exported text file. e.g. .zip";
			}

		}

		return $file;
	}
}