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

use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Container;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'bootstrap-italia-min', asset_path( 'bootstrap-italia/css/bootstrap-italia.min.css' ), false, '1.3.5' );
		wp_enqueue_style( 'bootstrap-italia-map', asset_path( 'bootstrap-italia/css/bootstrap-italia.min.css.map' ), false, '1.3.5' );
		wp_enqueue_style( 'sage/main.css', asset_path( 'styles/main.css' ), false, '1.3.5' );
		wp_enqueue_script( 'sage/main.js', asset_path( 'scripts/main.js' ), [ 'jquery' ], '1.3.5', true );
		wp_enqueue_script( 'bootstrap-italia-bundle-min', asset_path( 'bootstrap-italia/js/bootstrap-italia.bundle.min.js' ), array(), '1.3.5', true );
		if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	},
	100
);

/**
 * Theme setup
 */
add_action(
	'after_setup_theme',
	function () {
		/**
		 * Enable features from Soil when plugin is activated
		 *
		 * @link https://roots.io/plugins/soil/
		 */
		add_theme_support( 'soil-clean-up' );
		add_theme_support( 'soil-jquery-cdn' );
		add_theme_support( 'soil-nav-walker' );
		add_theme_support( 'soil-nice-search' );
		add_theme_support( 'soil-relative-urls' );

		/**
		 * Enable plugins to manage the document title
		 *
		 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
		 */
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Register navigation menus
		 *
		 * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
		 */
		register_nav_menus(
			array(
				'menu-main'    => __( 'Main Menu', 'wppa' ),
				'menu-servizi' => __( 'Servizi Menu', 'wppa' ),
				'menu-social'  => __( 'Social Menu', 'wppa' ),
				'menu-footer'  => __( 'Footer Menu', 'wppa' ),
			)
		);
		/**
		 * Enable post thumbnails
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'post-thumbnail-hero', 1920, 600, true);
		/**
		 * Enable HTML5 markup support
		 *
		 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
		 */
		add_theme_support( 'html5', [ 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ] );

		/**
		 * Enable selective refresh for widgets in customizer
		 *
		 * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 100,
				'width'       => 100,
				'flex-height' => true,
			)
		);

		add_theme_support(
			'custom-header',
			array(
				'flex-width'    => true,
				'width'         => 200,
				'flex-height'   => true,
				'height'        => 30,
				'default-image' => asset_path( '/images/header-image.png' ),
			)
		);
		add_theme_support( 'editor-styles' );

		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 640;
		}

		add_theme_support(
			'custom-background',
			array(
				'default-color' => 'ffffff',
				'default-image' => asset_path( '/images/blank.png' ),
			)
		);
		/**
		 * Use main stylesheet for visual editor
		 *
		 * @see resources/assets/styles/layouts/_tinymce.scss
		 */
		add_editor_style( asset_path( 'bootstrap-italia/css/bootstrap-italia.min.css' ) );
	},
	20
);

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'sage', get_template_directory() . '/langs/sage' );
	}
);

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'wpdi', get_template_directory() . '/langs/wpdi' );
	}
);

add_action(
	'comment_form_before',
	function () {
		if ( get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
);

/**
 * Register sidebars
 */
add_action(
	'widgets_init',
	function () {
		$config = [
			'before_widget' => '<section class="widget %1$s %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		];
		register_sidebar(
			[
				'name' => __( 'Primary', 'sage' ),
				'id'   => 'sidebar-primary',
			]
			+ $config
		);
		register_sidebar(
			[
				'name' => __( 'Footer', 'sage' ),
				'id'   => 'sidebar-footer',
			]
			+ $config
		);

		// FOOTER WIDGET AREAS.
		$footer_columns_schema    = get_theme_mod( 'footer_columns_schema', '8-4' );
		$number_of_footer_columns = substr_count( $footer_columns_schema, '-' ) + 1;

		for ( $count = 1; $count <= $number_of_footer_columns; $count ++ ) {
			register_sidebar(
				array(
					'name'          => __( 'Footer ', 'sage' ) . $count,
					'id'            => 'footer-' . $count,
					'description'   => '',
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h4 class="widget-title footer-widget-title">',
					'after_title'   => '</h4>',
				)
			);
		}
	}
);

/**
 * Add categories and tags to page
 */


add_action(
	'init',
	function () {
		register_taxonomy_for_object_type( 'post_tag', 'page' );
		register_taxonomy_for_object_type( 'category', 'page' );
	}
);

//hook into the init action and call create_book_taxonomies when it fires.
add_action(
	'init',
	function () {

		// Add new taxonomy, make it hierarchical like categories
		//first do the translations part for GUI.

		$labels = array(
			'name'              => _x( 'Sezioni di pubblicazioni', 'wppa' ),
			'singular_name'     => _x( 'Sezione di pubblicazione', 'wppa' ),
			'search_items'      => __( 'Cerca sezioni di pubblicazioni', 'wppa' ),
			'all_items'         => __( 'Tutte le sezioni di pubblicazione', 'wppa' ),
			'parent_item'       => __( 'Sezione genitore', 'wppa' ),
			'parent_item_colon' => __( 'Sezione genitore:', 'wppa' ),
			'edit_item'         => __( 'Modifica Sezione di pubblicazione', 'wppa' ),
			'update_item'       => __( 'Aggiorna  Sezione di pubblicazione', 'wppa' ),
			'add_new_item'      => __( 'Aggiungi nuova Sezione di pubblicazione', 'wppa' ),
			'new_item_name'     => __( 'Nuova Sezione di pubblicazione', 'wppa' ),
			'menu_name'         => __( 'Sezioni di pubblicazione', 'wppa' ),
		);

		// Now register the taxonomy.

		register_taxonomy( 'sezioni', array( 'post', 'page' ), array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_menu'      => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'topic' ),
			'capabilities'      => array(
				'assign_terms' => 'manage_options',
				'edit_terms'   => 'god',
				'manage_terms' => 'god',
			),
		),10000 );
	}
);

/* we could also add the word 'any' as a new WP_Query var, but it's always better to control each one of post_types */

if ( ! is_admin() ) {
	add_action(
		'pre_get_posts',
		function ( $wp_query ) {
			if ( $wp_query->is_main_query() && ( $wp_query->get( 'tag' ) || $wp_query->get( 'category_name' ) || $wp_query->get( 'cat' ) ) ) {
				$posttypes_list = $wp_query->get( 'post_type' );
				if ( is_string( $posttypes_list ) ) {  // we convert the string var in an array when it's necessary.
					$posttypes_list = array( $posttypes_list );
				}
				array_push( $posttypes_list, 'page', 'post' );            // And here we add the additional type of post_Type, the 'page'.
				$wp_query->set( 'post_type', $posttypes_list );
			}
		}
	);
}


/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action(
	'the_post',
	function ( $post ) {
		sage( 'blade' )->share( 'post', $post );
	}
);

/**
 * Setup Sage options
 */
add_action(
	'after_setup_theme',
	function () {
		/**
		 * Add JsonManifest to Sage container
		 */
		sage()->singleton(
			'sage.assets',
			function () {
				return new JsonManifest( config( 'assets.manifest' ), config( 'assets.uri' ) );
			}
		);

		/**
		 * Add Blade to Sage container
		 */
		sage()->singleton(
			'sage.blade',
			function ( Container $app ) {
				$cache_path = config( 'view.compiled' );
				if ( ! file_exists( $cache_path ) ) {
					wp_mkdir_p( $cache_path );
				}
				( new BladeProvider( $app ) )->register();

				return new Blade( $app['view'] );
			}
		);

		/**
		 * Create @asset() Blade directive
		 */
		sage( 'blade' )->compiler()->directive(
			'asset',
			function ( $asset ) {
				return '<?= ' . __NAMESPACE__ . '\\asset_path({$asset}); ?>';
			}
		);
	}
);

require_once get_template_directory() . '/lib/TMG-Plugin-Activation/class-tgm-plugin-activation.php';

add_action(
	'tgmpa_register',
	function () {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
			array(
				'name'     => 'PAFacile',
				'slug'     => 'pafacile',
				'required' => false,
			),
			array(
				'name'     => 'Menu Icons',
				'slug'     => 'menu-icons',
				'required' => false,
			),
			array(
				'name'     => 'Page Builder by SiteOrigin',
				'slug'     => 'siteorigin-panels',
				'required' => false,
			),
			array(
				'name'     => 'SiteOrigin Widgets Bundle',
				'slug'     => 'so-widgets-bundle',
				'required' => false,
			),
			array(
				'name'     => 'Kirki',
				'slug'     => 'kirki',
				'required' => true,
			),
		);

		$config = array(
			'id'           => 'sage',
			// Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',
			// Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins',
			// Menu slug.
			'parent_slug'  => 'themes.php',
			// Parent menu slug.
			'capability'   => 'edit_theme_options',
			// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,
			// Show admin notices or not.
			'dismissable'  => true,
			// If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',
			// If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,
			// Automatically activate plugins after installation or not.
			'message'      => '',
			// Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}
);
