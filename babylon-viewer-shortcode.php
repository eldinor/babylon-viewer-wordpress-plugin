<?php
/**
 * Plugin Name: Babylon Viewer v2 for WordPress
 * Plugin URI: https://babylonpress.org/
 * Description: Display 3D models with shortcode [babylonviewer]URL-OF-3D-FILE[/babylonviewer]. Supports GLTF, GLB, STL, OBJ+MTL, Babylon files, external URLs, and manual <babylon-viewer></babylon-viewer> usage in HTML blocks.
 * Version: 1.1.2
 * Author: Andrei Stepanov
 * Author URI: https://babylonpress.org/
 * License: GNU General Public License v3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: babylonviewer-shortcode
 * GitHub Plugin URI: https://github.com/eldinor/babylon-viewer-wordpress-plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Allow additional 3D file MIME types.
 */
function babylonviewerv2_upload_mime_types( $mimes ) {
	$mimes['gltf']    = 'model/gltf+json';
	$mimes['glb']     = 'model/gltf-binary';
	$mimes['obj']     = 'text/plain';
	$mimes['mtl']     = 'text/plain';
	$mimes['stl']     = 'model/stl';
	$mimes['babylon'] = 'application/json';

	return $mimes;
}
add_filter( 'upload_mimes', 'babylonviewerv2_upload_mime_types' );

/**
 * Fix file type detection for custom 3D formats.
 */
function babylonviewerv2_correct_filetypes( $data, $file, $filename, $mimes, $real_mime ) {
	if ( ! empty( $data['ext'] ) && ! empty( $data['type'] ) ) {
		return $data;
	}

	$wp_file_type = wp_check_filetype( $filename, $mimes );

	if ( empty( $wp_file_type['ext'] ) ) {
		return $data;
	}

	switch ( $wp_file_type['ext'] ) {
		case 'gltf':
			$data['ext']  = 'gltf';
			$data['type'] = 'model/gltf+json';
			break;

		case 'glb':
			$data['ext']  = 'glb';
			$data['type'] = 'model/gltf-binary';
			break;

		case 'babylon':
			$data['ext']  = 'babylon';
			$data['type'] = 'application/json';
			break;

		case 'obj':
			$data['ext']  = 'obj';
			$data['type'] = 'text/plain';
			break;

		case 'mtl':
			$data['ext']  = 'mtl';
			$data['type'] = 'text/plain';
			break;

		case 'stl':
			$data['ext']  = 'stl';
			$data['type'] = 'model/stl';
			break;
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'babylonviewerv2_correct_filetypes', 10, 5 );

/**
 * Register Babylon Viewer script.
 */
function babylonviewerv2_register_assets() {
	wp_register_script(
		'babylon-viewer',
		'https://cdn.jsdelivr.net/npm/@babylonjs/viewer@8.56.1/dist/babylon-viewer.esm.min.js',
		array(),
		'8.56.1',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'babylonviewerv2_register_assets' );

/**
 * Force script tag to be type="module" for Babylon Viewer ESM build.
 */
function babylonviewerv2_script_loader_tag( $tag, $handle, $src ) {
	if ( 'babylon-viewer' !== $handle ) {
		return $tag;
	}

	return '<script type="module" src="' . esc_url( $src ) . '"></script>' . "\n";
}
add_filter( 'script_loader_tag', 'babylonviewerv2_script_loader_tag', 10, 3 );

/**
 * Decide whether Babylon Viewer should be loaded.
 */
function babylonviewerv2_maybe_enqueue() {
	if ( is_admin() ) {
		return;
	}

	if ( ! is_singular() ) {
		return;
	}

	$post = get_queried_object();

	if ( ! ( $post instanceof WP_Post ) ) {
		return;
	}

	$content = (string) $post->post_content;

	if (
		has_shortcode( $content, 'babylonviewer' ) ||
		strpos( $content, '<babylon-viewer' ) !== false
	) {
		wp_enqueue_script( 'babylon-viewer' );
	}
}
add_action( 'wp_enqueue_scripts', 'babylonviewerv2_maybe_enqueue', 20 );

/**
 * Shortcode output.
 * Usage: [babylonviewer]https://example.com/model.glb[/babylonviewer]
 */
function babylonviewerv2_shortcode( $atts = array(), $content = null ) {
	$url = trim( (string) $content );

	if ( empty( $url ) ) {
		return '';
	}

	$url = esc_url( $url );

	if ( empty( $url ) ) {
		return '';
	}

	wp_enqueue_script( 'babylon-viewer' );

	return '<babylon-viewer source="' . esc_url( $url ) . '" style="display:block;width:100%;height:500px;"></babylon-viewer>';
}
add_shortcode( 'babylonviewer', 'babylonviewerv2_shortcode' );
