<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 17/01/19
 * Time: 21.59
 * PHP Version 5.6
 *
 * @package Controllers\App
 */

namespace App\Controllers;

use Sober\Controller\Controller;
use function App\asset_path;

/**
 * Class App
 *
 * @package App\Controllers
 */
class App extends Controller {
	/**
	 * Return site name.
	 *
	 * @return string|void
	 */
	public function siteName() {
		return get_bloginfo( 'name' );
	}

	/**
	 * Return site title.
	 *
	 * @return string|void
	 */
	public static function title() {
		if ( is_home() ) {
			$home = get_option( 'page_for_posts', true );
			if ( $home ) {
				return get_the_title( $home );
			}
			return __( 'Latest Posts', 'sage' );
		}
		if ( is_archive() ) {
			return get_the_archive_title();
		}
		if ( is_search() ) {
			// translators: Traduce inserendo il termine cercato.
			return sprintf( __( 'Search Results for %s', 'sage' ), get_search_query() );
		}
		if ( is_404() ) {
			return __( 'Not Found', 'sage' );
		}
		return get_the_title();
	}

	/**
	 * Return if show featured image.
	 *
	 * @param int $post_id post identifier.
	 *
	 * @return mixed
	 */
	public static function feautured_image_show( $post_id ) {
		return get_post_meta( $post_id, '_featured_image_show', true ) !== '' ?
			get_post_meta( $post_id, '_featured_image_show', true )
			: get_theme_mod( 'single_post_show_thumbnail', true );
	}

	/**
	 * Return featured image alignment.
	 *
	 * @param int $post_id post identifier.
	 *
	 * @return mixed
	 */
	public static function feautured_image_align( $post_id ) {
		return get_post_meta( $post_id, '_featured_image_align', true ) !== '' ?
			get_post_meta( $post_id, '_featured_image_align', true )
			: get_theme_mod( 'single_post_align_thumbnail', true );
	}

	/**
	 * Return featured image config.
	 *
	 * @param int $post_id post identifier.
	 *
	 * @return array
	 */
	public static function feautured_image_config( $post_id ) {
		$data                         = array();
		$data['featured_image_show']  = get_post_meta( $post_id, '_featured_image_show', true ) !== '' ? get_post_meta( $post_id, '_featured_image_show', true ) : get_theme_mod( 'single_post_show_thumbnail', true );
		$data['featured_image_align'] = get_post_meta( $post_id, '_featured_image_align', true ) ?: get_theme_mod( 'single_post_align_thumbnail', 'right' );
		$data['featured_image_size']  = get_post_meta( $post_id, '_featured_image_size', true ) ?: get_theme_mod( 'single_post_thumbnail_size', 'thumbnail' );
		return $data;
	}

	/**
	 * Return social link html snipper.
	 *
	 * @return string
	 */
	public static function social_links() {
		if ( ! get_theme_mod( 'sl_replace_menu', false ) ) {
			return '';
		}
		$sl_values = get_theme_mod( 'social_links', [] );
		if ( count( $sl_values ) === 0 ) {
			return '';
		}
		$html      = '<span hidden="true" class="visuallyhidden">' . esc_html__( 'Seguici su', 'wppa' ) . '</span>';
		$html     .= '<ul>';
		$icon_path = asset_path( 'bootstrap-italia/svg/sprite.svg' );
		foreach ( $sl_values as $sl_value ) {
			$html     .= '<li>';
			$link_icon = sprintf( '<span hidden="true" class="visuallyhidden">%s</span><svg class="icon"><use xlink:href="%s#it-%s"></use></svg>', $sl_value['link_text'], $icon_path, $sl_value['icon_id'] );
			$link_url  = sprintf( '<a href="%s" title="%s">%s</a>', $sl_value['link_url'], $sl_value['link_text'], $link_icon );
			$html     .= $link_url;
			$html     .= '</li>';
		}
		$html .= '</ul>';
		return $html;
	}

	/**
	 * Return custom logo html snippet.
	 *
	 * @param int $blog_id Blog identifier.
	 */
	public static function wpdi_the_custom_logo( $blog_id = 0 ) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$logo           = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		if ( has_custom_logo() ) {
			echo '<img class="icon logosite" src="' . esc_url( $logo[0] ) . '">';
		} else {
			echo '<img class="icon logosite" src="' . esc_url( asset_path( 'images/custom-logo.png' ) ) . '">';
		}
	}

	/**
	 * Return footer menu html snippet if defined in paramenter theme location.
	 *
	 * @param string $theme_location Theme location.
	 */
	public static function create_footer_menu( $theme_location ) {
		$locations = get_nav_menu_locations();
		if ( ( isset( $locations ) ) && ( $theme_location ) && isset( $locations[ $theme_location ] ) ) {
			$menu_list   = "\n";
			$menu        = get_term( $locations[ $theme_location ], 'nav_menu' );
			$menu_items  = wp_get_nav_menu_items( $menu->term_id );
			$section_tag = '<div class="col-footer col-lg-3 col-md-3 col-sm-6">';
			$bool        = false;
			foreach ( $menu_items as $menu_item ) {
				if ( 0 === intval( $menu_item->menu_item_parent ) ) {
					$parent     = $menu_item->ID;
					$menu_array = array();
					foreach ( $menu_items as $submenu ) {
						if ( intval( $submenu->menu_item_parent ) === intval( $parent ) ) {
							$bool         = true;
							$menu_array[] = '<li><a class="list-item" href="' . $submenu->url . '">' . $submenu->title . '</a></li>' . "\n";
						}
					}
					$menu_list .= $section_tag . "\n";
					$menu_list .= '<h4><a href="' . $menu_item->url . '" title="' . $menu_item->title . '"><svg class="icon"><use xlink:href="' . asset_path( 'bootstrap-italia/svg/sprite.svg' ) . '#it-pa"></use></svg>' . $menu_item->title . '</a></h4>' . "\n";
					if ( true === boolval( $bool ) && count( $menu_array ) > 0 ) {
						$menu_list .= '<div class="link-list-wrapper"><ul class="footer-list link-list clearfix">' . "\n";
						$menu_list .= implode( "\n", $menu_array );
						$menu_list .= '</div></ul>' . "\n";
					}
					$menu_list .= '</div>' . "\n";
				}
			}
		} else {
			$menu_list = '<!-- no menu defined in location "' . $theme_location . '" -->';
		}
		echo $menu_list;
	}

	/**
	 * Return main category for post.
	 *
	 * @param bool $post_id Post id.
	 *
	 * @return string
	 */
	public static function get_main_category( $post_id = false ) {
		global $wp_rewrite;
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}
		$main_category_id = get_post_meta( $post_id, 'main_category', true );
		if ( '' === strval( $main_category_id )) {
			$categories       = wp_get_post_terms( $post_id, 'category', array( 'orderby' => 'term_id' ) );
			$main_category_id = $categories[0]->term_id;
		}
		return get_category_parents( $main_category_id, true, '<span class="separator">/</span></li><li class="breadcrumb-item">' );
			// $main_category = get_term($main_category_id);
			// $rel = (is_object($wp_rewrite) && $wp_rewrite->using_permalinks()) ? 'rel="category tag"' : 'rel="category"';
			// return '<a href="' . esc_url(get_category_link($main_category->term_id)) . '" ' . $rel . '>' . $main_category->name . '</a>';

		return '';
	}

	/**
	 * Return true if show post author.
	 *
	 * @return bool
	 */
	public static function show_author() {
		return get_theme_mod( 'single_post_show_author' ) !== '';
	}

	/**
	 * AGGIUNGI BREADCRUMP NEI POST.
	 *
	 * @return string
	 */
	public static function wp_breadcrumb() {
		$bc  = '';
		$bc .= '<nav aria-label="breadcrumb" class="breadcrumb-container">';
		$bc .= '<ol class="breadcrumb">';
		$bc .= '<li class="breadcrumb-item"><a href="' . esc_attr( home_url() ) . '" rel="nofollow">Home</a><span class="separator">/</span></li>';

		if ( is_category() || is_single() || is_page() ) {
			$bc .= '<li class="breadcrumb-item">';
			$mc  = self::get_main_category();

			if ( '' !== $mc ) {
				$bc .= $mc;
			}
			if ( is_single() || is_page() ) {
				$bc .= get_the_title();
				$bc .= '</li>';
			}
			$bc .= '</li>';
		} elseif ( is_search() ) {
			$bc .= '&nbsp;&nbsp;&#187;&nbsp;&nbsp;Cerca risultati per... ';
			$bc .= '"<em>';
			$bc .= get_the_search_query();
			$bc .= '</em>"';
		}
		$bc .= '</ol>';
		$bc .= '</nav>';
		return $bc;
	}

}
