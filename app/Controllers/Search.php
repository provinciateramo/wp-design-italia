<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 17/01/19
 * Time: 21.59
 *
 * @package Controllers\App
 */

namespace app\Controllers;

use Sober\Controller\Controller;

/**
 * Class Search
 *
 * @package app\Controllers
 */
class Search extends Controller {
	/**
	 * Return categories with icons.
	 *
	 * @return array
	 */
	public static function main_category() {
		$terms = get_categories(
			array(
				'parent'  => 0,
				'orderby' => 'term_id',
			)
		);
		foreach ( $terms as $term ) {
			$term->icon_cat_id = get_term_meta( $term->term_id, 'icon_cat_id', true );
		}
		return $terms;
	}

	/**
	 * Return all categories.
	 *
	 * @return array
	 */
	public static function all_category() {
		$main_cats = self::main_category();
		$items     = array();
		foreach ( $main_cats as $main_cat ) {
			$main_cat->sub = get_terms( 'category', array( 'child_of' => $main_cat->term_id ) );
		}
		return $main_cats;
	}

	/**
	 * Return all terms.
	 *
	 * @return array|int|\WP_Error
	 */
	public static function all_terms() {
		$items = get_terms(
			array(
				'taxonomy'   => 'post_tag',
				'hide_empty' => false,
			)
		);

		return $items;
	}
}
