<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 27/02/19
 * Time: 8.07
 * PHP version 7.0
 *
 * @package App
 */

namespace App;

/**
 * Elenco possibili allineamenti dell'immagine principale.
 *
 * @return array
 */
function imagealign_list() {
	return array(
		'right'  => esc_html__( 'Destra', 'wpdi' ),
		'left'   => esc_html__( 'Sinistra', 'wpdi' ),
		'center' => esc_html__( 'Centro', 'wpdi' ),
		'hero'   => esc_html__( 'Grande', 'wpdi' ),
		'none'   => esc_html__( 'Nessun allineamento', 'wpdi' ),
	);
}

/**
 * Elenco possibili dimensioni dell'immagine principale.
 *
 * @return array
 */
function imagesize_list() {
	global $_wp_additional_image_sizes;
	$image_sizes_choices = array();

	foreach ( get_intermediate_image_sizes() as $_size ) {
		if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ), true ) ) {
			$image_sizes_choices[ $_size ] = esc_html__( $_size, 'wpdi' ) . '(' . get_option( "{$_size}_size_w" ) . ' x ' . get_option( "{$_size}_size_h" ) . ')';
		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
			$image_sizes_choices[ $_size ] = esc_html__( $_size, 'wpdi' ) . '(' . get_option( "{$_size}_size_w" ) . ' x ' . get_option( "{$_size}_size_h" ) . ')';
		}
	}

	return $image_sizes_choices;
}


/**
 * Add <body> classes
 */
add_filter(
	'body_class',
	function ( array $classes ) {
		/** Add page slug if it doesn't exist */
		if ( is_single() || is_page() && ! is_front_page() ) {
			if ( ! in_array( basename( get_permalink() ), $classes ) ) {
				$classes[] = basename( get_permalink() );
			}
		}

		/** Add class if sidebar is active */
		if ( display_sidebar() ) {
			$classes[] = 'sidebar-primary';
		}

		/** Clean up class names for custom templates */
		$classes = array_map(
			function ( $class ) {
				return preg_replace( [ '/-blade(-php)?$/', '/^page-template-views/' ], '', $class );
			},
			$classes
		);
		return array_filter( $classes );
	}
);

/**
 * Add "… Continued" to the excerpt
 */
add_filter(
	'excerpt_more',
	function () {
		return ' &hellip; <a href="' . get_permalink() . '">' . __( 'Continued', 'sage' ) . '</a>';
	}
);

/**
 * Template Hierarchy should search for .blade.php files
 */
collect(
	[
		'index',
		'404',
		'archive',
		'author',
		'category',
		'tag',
		'taxonomy',
		'date',
		'home',
		'frontpage',
		'page',
		'paged',
		'search',
		'single',
		'singular',
		'attachment',
	]
)->map(
	function ( $type ) {
		add_filter( "{$type}_template_hierarchy", __NAMESPACE__ . '\\filter_templates' );
	}
);

/**
 * Render page using Blade
 */
add_filter(
	'template_include',
	function ( $template ) {
		$data = collect( get_body_class() )->reduce(
			function ( $data, $class ) use ( $template ) {
				return apply_filters( "sage/template/{$class}/data", $data, $template );
			},
			[]
		);
		if ( $template ) {
			echo template( $template, $data );

			return get_stylesheet_directory() . '/index.php';
		}

		return esc_html( $template );
	},
	PHP_INT_MAX
);

/**
 * Render comments.blade.php
 */
add_filter(
	'comments_template',
	function ( $comments_template ) {
		$comments_template = str_replace( [ get_stylesheet_directory(), get_template_directory() ], '', $comments_template );

		$data = collect( get_body_class() )->reduce(
			function ( $data, $class ) use ( $comments_template ) {
				return apply_filters( "sage/template/{$class}/data", $data, $comments_template );
			},
			[]
		);

		$theme_template = locate_template( [ "views/{$comments_template}", $comments_template ] );

		if ( $theme_template ) {
			echo template( $theme_template, $data );

			return get_stylesheet_directory() . '/index.php';
		}

		return $comments_template;
	},
	100
);

add_filter(
	'the_title',
	function ( $title ) {
		if ( '' === $title ) {
			return '&rarr;';
		} else {
			return $title;
		}
	}
);

add_filter(
	'get_the_archive_title',
	function ( $title ) {

		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_archive() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		}

		return $title;
	},
	100
);

add_filter(
	'wp_title',
	function ( $title ) {
		return $title . esc_attr( get_bloginfo( 'name' ) );
	}
);

add_filter(
	'get_comments_number',
	function ( $count ) {
		if ( ! is_admin() ) {
			global $id;
			$comments         = get_comments( 'status=approve&post_id=' . $id );
			$comments_by_type = separate_comments( $comments );

			return count( $comments_by_type['comment'] );
		} else {
			return $count;
		}
	}
);

add_filter(
	'sage/display_sidebar',
	function ( $display ) {
		static $display;

		isset( $display ) || $display = in_array(
			true,
			[
				// The sidebar will be displayed if any of the following return true.
				is_single(),
				is_404(),
				is_page_template( 'template-custom.php' ),
			],
			true
		);

		return $display;
	}
);

add_filter(
	'nav_menu_link_attributes',
	function ( $atts, $item, $args ) {
		if ( array_key_exists( 'link_class', $args ) ) {
			$atts['class'] = $args->link_class;
		}

		return $atts;
	},
	1,
	3
);

add_filter(
	'nav_menu_css_class',
	function ( $classes, $item, $args ) {
		if ( array_key_exists( 'list_item_class', $args ) ) {
			$classes[] = $args->list_item_class;
		}

		return $classes;
	},
	1,
	3
);

add_filter(
	'excerpt_length',
	function ( $length ) {
		$custom = get_theme_mod( 'custom_excerpt_length' );
		if ( '' !== $custom ) {
			$length = intval( $custom );
			return $length;
		} else {
			return 10;
		}
	},
	10
);


add_filter(
	'mce_buttons_2',
	function ( $buttons ) {
		array_unshift( $buttons, 'styleselect' );

		return $buttons;
	}
);

/*
* Callback function to filter the MCE settings
*/


// Attach callback to 'tiny_mce_before_init'.
add_filter(
	'tiny_mce_before_init',
	function ( $init_array ) {

		// Define the style_formats array.

		$style_formats = array(
			array(
				'title' => 'Pulsanti',
				'items' => array(
					array(
						'title'      => 'Bottone principale',
						'block'      => 'a',
						'classes'    => 'btn btn-primary',
						'attributes' => array(
							'href' => '#',
						),
						'wrapper'    => true,
					),
					array(
						'title'      => 'Bottone secondario',
						'block'      => 'a',
						'classes'    => 'btn btn-secondary',
						'attributes' => array(
							'href' => '#',
						),
						'wrapper'    => true,
					),
					array(
						'title'      => 'Bottone verde',
						'block'      => 'a',
						'classes'    => 'btn btn-success',
						'attributes' => array(
							'href' => '#',
						),
						'wrapper'    => true,
					),
					array(
						'title'      => 'Bottone rosso',
						'block'      => 'a',
						'classes'    => 'btn btn-danger',
						'attributes' => array(
							'href' => '#',
						),
						'wrapper'    => true,
					),
					array(
						'title'      => 'Bottone giallo',
						'block'      => 'a',
						'classes'    => 'btn btn-warning',
						'attributes' => array(
							'href' => '#',
						),
						'wrapper'    => true,
					),
					array(
						'title'      => 'Bottone piatto',
						'block'      => 'a',
						'classes'    => 'btn btn-link',
						'attributes' => array(
							'href' => '#',
						),
						'wrapper'    => true,
					),
				),
			),
			array(
				'title' => 'Avvisi',
				'items' => array(
					array(
						'title'      => 'Avviso principale',
						'block'      => 'div',
						'classes'    => 'alert alert-primary',
						'attributes' => array(
							'role' => 'alert',
						),
						'wrapper'    => true,
					),
					array(
						'title'      => 'Avviso secondario',
						'block'      => 'div',
						'classes'    => 'alert alert-secondary',
						'attributes' => array(
							'role' => 'alert',
						),
						'wrapper'    => true,
					),
					array(
						'title'      => 'Avviso verde',
						'block'      => 'div',
						'classes'    => 'alert alert-success',
						'attributes' => array(
							'role' => 'alert',
						),
						'wrapper'    => true,
					),
					array(
						'title'      => 'Avviso rosso',
						'block'      => 'div',
						'classes'    => 'alert alert-danger',
						'attributes' => array(
							'role' => 'alert',
						),
						'wrapper'    => true,
					),
					array(
						'title'      => 'Avviso giallo',
						'block'      => 'div',
						'classes'    => 'alert alert-warning',
						'attributes' => array(
							'role' => 'alert',
						),
						'wrapper'    => true,
					),
					array(
						'title'      => 'Avviso piatto',
						'block'      => 'div',
						'classes'    => 'alert alert-link',
						'attributes' => array(
							'role' => 'alert',
						),
						'wrapper'    => true,
					),
				),
			),

		);
		// Insert the array, JSON ENCODED, into 'style_formats'.
		$init_array['style_formats'] = wp_json_encode( $style_formats );

		return $init_array;
	}
);

add_action(
	'init',
	function () {
		add_editor_style( asset_path( 'bootstrap-italia/css/bootstrap-italia.min.css' ) );
		add_editor_style( asset_path( 'bootstrap-italia/css/italia-icon-font.css' ) );
	}
);
