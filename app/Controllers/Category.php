<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 06/03/19
 * Time: 10.46
 *
 * @package Controllers\App
 */

namespace app\Controllers;

use Sober\Controller\Controller;

/**
 * Class Category
 *
 * @package app\Controllers
 */
class Category extends Controller {
	/**
	 * Return categories html snippet.
	 *
	 * @param bool   $post_id Post id.
	 * @param string $css_class Css class to apply.
	 *
	 * @return string
	 */
	public static function category_links( $post_id = false, $css_class = 'badge border border-primary mr-1 mb-1' ) {
		$html = '';
		foreach ( get_the_category( $post_id ) as $cat ) {
			$html .= '<a href="' . get_category_link( $cat->term_id ) . '" class="' . $css_class . '">' . $cat->name . '</a>';
		}
		return $html;
	}
}
