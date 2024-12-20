<?php
/**
 * Plugin Name: Babylon Viewer v2 for Wordpress
 * Plugin URI: https://babylonpress.org/
 * Description: Display 3D models with the help of shortcode [babylonviewer]URL-OF-3D-FILE[/babylonviewer] to use the 3D Viewer v2 in Wordpress posts and pages, Woocommerce products, Elementor blocks etc. Supports GLTF, GLB, STL, OBJ+MTL files upload and demonstration as a viewing experience for 3D models.  All aspects of this experience are configurable. If you need more control, you may use <babylon-viewer></babylon-viewer> tag in any Wordpress HTML block and configure all needed parameters with JS. Supports external URLs. Doesn't write any data to WP database.
 * Version: 1.1
 * Author: Andrei Stepanov
 * Author URI: https://babylonpress.org/
 * Licence: GNU General Public License v3.0
 * Licence URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: babylonviewer-shortcode
 * GitHub Plugin URI: https://github.com/eldinor/babylon-viewer-wordpress-plugin
 */

// SECURITY: to ensure PHP execution is only allowed when it is included as part of the core system.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Adding new MIME types.
function babylonviewerv2_upload_mime_types( $mimes ) {
// Add new allowed MIME types here.
    $mimes['gltf'] = 'model/gltf+json';
    $mimes['glb'] = 'model/gltf-binary';
    $mimes['obj'] = 'model/obj';
    $mimes['mtl'] = 'model/mtl';
    $mimes['stl'] = 'model/stl';
    $mimes['babylon'] = 'model/babylon+json';
// Return the array back to the function with our added MIME type(s).
    return $mimes;
}
add_filter( 'upload_mimes', 'babylonviewerv2_upload_mime_types' );

// Add allowed filetypes.
function babylonviewerv2_correct_filetypes( $data, $file, $filename, $mimes, $real_mime ) {
    if ( ! empty( $data['ext'] ) && ! empty( $data['type'] ) ) {
      return $data;
    }
    $wp_file_type = wp_check_filetype( $filename, $mimes );

// Check for the file type you want to enable, e.g. 'gltf'.
    if ( 'gltf' === $wp_file_type['ext'] ) {
      $data['ext']  = 'gltf';
      $data['type'] = 'model/gltf+json';
    }
    if ( 'glb' === $wp_file_type['ext'] ) {
      $data['ext']  = 'glb';
      $data['type'] = 'model/gltf-binary';
    }
    if ( 'babylon' === $wp_file_type['ext'] ) {
      $data['ext']  = 'babylon';
      $data['type'] = 'model/babylon+json';
    }
        if ( 'obj' === $wp_file_type['ext'] ) {
      $data['ext']  = 'obj';
      $data['type'] = 'model/obj';
    }
        if ( 'mtl' === $wp_file_type['ext'] ) {
      $data['ext']  = 'mtl';
      $data['type'] = 'model/mtl';
    }
        if ( 'stl' === $wp_file_type['ext'] ) {
      $data['ext']  = 'stl';
      $data['type'] = 'model/stl';
    }
    return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'babylonviewerv2_correct_filetypes' , 10, 5 );

// Adding Babylon Viewer into header
function babylonviewerv2_call() {
   if ( strpos( get_the_content(), '[babylonviewer]' ) !== false || strpos( get_the_content(), '</babylon-viewer>' ) !== false ) {
    wp_enqueue_script_module( 'babylon-viewer', esc_url_raw( 'https://cdn.jsdelivr.net/npm/@babylonjs/viewer@7.41.1-alpha/dist/babylon-viewer.esm.min.js' ), array(), null, true );
   }
} // END babylonviewer_call()
add_action( 'wp_enqueue_scripts', 'babylonviewerv2_call' );

// Adding Babylon Viewer shortcode
function babylonviewerv2_shortcode($atts = [], $content = null) {
    $url = esc_url_raw($content);
    $content = '<babylon-viewer ';
    $content .=	'source="';
 	$content .= $url;
 	$content .= '"></babylon-viewer>';
    return $content;
}
add_shortcode('babylonviewer', 'babylonviewerv2_shortcode');
