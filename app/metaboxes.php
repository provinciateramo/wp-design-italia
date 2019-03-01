<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 24/12/18
 * Time: 11.54
 */

namespace App;
namespace App\Metabox;

add_action('init', function (){
    global $wp_registered_sidebars;
    $sidebars = $wp_registered_sidebars;
    $sidebar_options = array();
    foreach ( $sidebars as $sidebar ){
        $sidebar_options[$sidebar['id']] = $sidebar['name'];
    }
    //var_dump($sidebar_options); // debug
    return $sidebar_options;
});


$mc_meta_box = new MainCategoryMetabox();
$featured_image_metabox = new FeaturedImageMetabox();
$show_sidebar_meta_box = new ShowSidebarMetabox();

