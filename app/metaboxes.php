<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 24/12/18
 * Time: 11.54
 * Php version 7.0
 */

namespace App\Metabox;

add_action(
	'init',
	function () {
		global $wp_registered_sidebars;
		$sidebars        = $wp_registered_sidebars;
		$sidebar_options = array();
		foreach ( $sidebars as $sidebar ) {
			$sidebar_options[ $sidebar['id'] ] = $sidebar['name'];
		}
		return $sidebar_options;
	}
);

$mc_metabox             = new Main_Category_Metabox();
$featured_image_metabox = new Featured_Image_Metabox();
$show_sidebar_metabox   = new Show_Sidebar_Metabox();
